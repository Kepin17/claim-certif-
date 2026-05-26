<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact the administrator.',
                ])->withInput();
            }
            
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
            return redirect()->route('admin.otp.verify')->with('info', 'OTP code has been sent to your email.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
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
            return redirect()->route('admin.dashboard');
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

        return redirect()->route('admin.otp.verify')->with('info', 'OTP code has been resent to your email.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('otp_user_id');
        session()->forget('otp_verified');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
