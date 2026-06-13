<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function checkEmail(Request $request)
    {
        $email = $request->query('email', '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['exists' => false]);
        }

        $exists = User::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['nullable'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        // Check if this is a new user registration attempt
        $userExists = User::where('email', $credentials['email'])->exists();
        
        // For new users, validate password confirmation
        if (!$userExists && empty($credentials['name'])) {
            return back()
                ->withInput()
                ->with('show_name_field', true)
                ->with('info', 'Please enter your name and confirm password to create your account.');
        }

        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->withInput();
        }

        // Check if user exists
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // New user - check if name is provided
            if (empty($credentials['name'])) {
                return back()
                    ->withInput()
                    ->with('show_name_field', true)
                    ->with('info', 'We don\'t recognize this email. Please enter your name to create a new account.');
            }

            // Create new user (regular user role by default)
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => \Hash::make($credentials['password']),
                'is_active' => true,
                'role' => 'user',
            ]);

            \Log::info('New user auto-registered', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        } else {
            // Existing user - try to authenticate (only email and password)
            $authCredentials = [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ];
            if (!Auth::attempt($authCredentials, $request->filled('remember'))) {
                RateLimiter::hit($key, 300);
                return back()->withErrors([
                    'email' => 'The provided password is incorrect.',
                ])->withInput();
            }

            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                RateLimiter::hit($key, 300);
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact the administrator.',
                ])->withInput();
            }
        }

        RateLimiter::clear($key);
        
        // All users require OTP verification
        // Generate and store OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        try {
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();
            
            \Log::info('OTP Generated and Saved', [
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => $user->otp_expires_at,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to save OTP', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);
            return back()->withErrors(['email' => 'Failed to generate OTP. Please try again.'])->withInput();
        }

        // Send OTP via email
        Mail::raw("Your OTP code is: {$otp}\n\nThis code will expire in 10 minutes.", function($message) use ($user) {
            $message->to($user->email)
                ->subject('Your OTP Code');
        });

        // Logout and redirect to OTP verification
        Auth::logout();
        session(['otp_user_id' => $user->id]);
        return redirect()->route('otp.verify')->with('info', 'OTP code has been sent to your email.');
    }

    public function showOTPVerify()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('admin.otp-verify');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found. Please login again.');
        }

        // Debug: Log OTP values
        \Log::info('OTP Verification', [
            'submitted_otp' => $request->otp,
            'stored_otp' => $user->otp_code,
            'expires_at' => $user->otp_expires_at,
            'now' => now(),
            'is_expired' => !$user->otp_expires_at || $user->otp_expires_at < now(),
        ]);

        // Verify OTP
        if ($user->otp_code === $request->otp && $user->otp_expires_at && $user->otp_expires_at > now()) {
            // Clear OTP
            try {
                $user->otp_code = null;
                $user->otp_expires_at = null;
                $user->save();
            } catch (\Exception $e) {
                \Log::error('Failed to clear OTP', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                ]);
            }

            // Login user
            Auth::login($user);
            session(['otp_verified' => true]);
            session()->forget('otp_user_id');
            $request->session()->regenerate();
            
            // Redirect based on role
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                \Log::info('Admin user logged in', ['user_id' => $user->id, 'role' => $user->role]);
                return redirect()->route('admin.dashboard');
            } else {
                // Regular user (role = 'user' or null) - redirect to events page
                \Log::info('Regular user logged in', ['user_id' => $user->id, 'role' => $user->role]);
                return redirect()->route('certificate.index')
                    ->with('success', 'Welcome, ' . $user->name . '!');
            }
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP code.'])->withInput();
    }

    public function resendOTP(Request $request)
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        try {
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();
            
            \Log::info('OTP Regenerated', [
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => $user->otp_expires_at,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to regenerate OTP', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);
            return back()->withErrors(['otp' => 'Failed to regenerate OTP. Please try again.']);
        }

        // Send OTP via email
        Mail::raw("Your OTP code is: {$otp}\n\nThis code will expire in 10 minutes.", function($message) use ($user) {
            $message->to($user->email)
                ->subject('Your OTP Code');
        });

        return redirect()->route('otp.verify')->with('info', 'OTP code has been resent to your email.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('otp_user_id');
        session()->forget('otp_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // User Profile Methods
    public function showUserProfile()
    {
        $user = Auth::user();
        return view('auth.user-profile', compact('user'));
    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Check if email is being changed
        if ($validated['email'] !== $user->email) {
            // Check if new email already exists
            $existingUser = \App\Models\User::where('email', $validated['email'])->first();
            if ($existingUser && $existingUser->id !== $user->id) {
                return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
            }

            // Store pending email change in session and send OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            try {
                // Save OTP to user record (using otp_code field temporarily)
                $user->otp_code = $otp;
                $user->otp_expires_at = now()->addMinutes(10);
                $user->save();
                
                // Store pending email and name in session
                session(['pending_email' => $validated['email']]);
                session(['pending_name' => $validated['name']]);
                session(['email_change_otp' => true]);
                
                \Log::info('Email Change OTP Generated', [
                    'user_id' => $user->id,
                    'new_email' => $validated['email'],
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to save Email Change OTP', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                ]);
                return back()->withErrors(['email' => 'Failed to generate verification code. Please try again.'])->withInput();
            }

            // Send OTP to NEW email address
            Mail::raw("Your email verification code is: {$otp}\n\nThis code will expire in 10 minutes.\n\nIf you did not request this change, please ignore this email.", function($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Verify Your New Email Address');
            });

            return redirect()->route('user.profile')
                ->with('email_changed', true)
                ->with('info', 'Verification code sent to ' . $validated['email'] . '. Please enter the code to complete the email change.');
        }

        // Only name changed, update directly
        $user->update(['name' => $validated['name']]);

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = Auth::user();
        
        if (!session('email_change_otp') || !session('pending_email')) {
            return redirect()->route('user.profile')
                ->with('error', 'Email change session expired. Please try again.');
        }

        // Verify OTP
        if ($user->otp_code === $request->otp && $user->otp_expires_at && $user->otp_expires_at > now()) {
            // Clear OTP fields
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();
            
            // Update email and name
            $user->update([
                'name' => session('pending_name'),
                'email' => session('pending_email'),
            ]);
            
            // Clear session
            session()->forget('pending_email');
            session()->forget('pending_name');
            session()->forget('email_change_otp');
            
            // Re-verify OTP for continued login
            session(['otp_verified' => true]);

            return redirect()->route('user.profile')
                ->with('success', 'Email address updated successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid or expired verification code.'])->withInput();
    }

    public function updateUserPassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!\Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ])->withInput();
        }

        $user->update([
            'password' => \Hash::make($validated['new_password']),
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Password updated successfully!');
    }
}
