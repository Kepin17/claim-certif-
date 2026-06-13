<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOTPVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // All users require OTP verification
            if (!session('otp_verified')) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'OTP verification required. Please login again.');
            }
            
            // Check if user is trying to access admin routes
            if ($request->is('admin/*') || $request->routeIs('admin.*')) {
                // Only admin and superadmin can access admin routes
                if ($user->role !== 'admin' && $user->role !== 'superadmin') {
                    return redirect()->route('certificate.index')
                        ->with('error', 'You do not have permission to access this area.');
                }
            }
        }

        return $next($request);
    }
}
