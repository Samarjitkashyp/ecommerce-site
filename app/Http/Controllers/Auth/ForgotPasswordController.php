<?php
// app/Http/Controllers/Auth/ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * 🔥 FIXED: Laravel 11 compatible password reset
     */
    public function sendResetLink(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email|exists:users,email']);

            // 🔥 Rate limiting to prevent spam
            $key = 'password-reset:' . $request->ip();
            if (RateLimiter::tooManyAttempts($key, 3)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many attempts. Please try again after ' . 
                                RateLimiter::availableIn($key) . ' seconds.'
                ], 429);
            }

            RateLimiter::hit($key, 60); // 1 attempt per minute

            // 🔥 Laravel 11 password broker
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Password reset link has been sent to your email.'
                ]);
            }

            return response()->json([
                'success' => false, 
                'message' => 'Failed to send reset link. Please try again.'
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Forgot password error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset link. Please try again.'
            ], 500);
        }
    }
}