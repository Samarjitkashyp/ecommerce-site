<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                
                // Update last login info
                $user->last_login_at = now();
                $user->last_login_ip = $request->ip();
                $user->save();

                // Regenerate session
                $request->session()->regenerate();

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => $request->has('redirect') ? $request->redirect : route('account.dashboard')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please try again.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}