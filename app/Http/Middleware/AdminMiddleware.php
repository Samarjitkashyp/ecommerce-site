<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * HANDLE AN INCOMING REQUEST
     * Check if user is authenticated and is admin
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // 🟢 SIMPLE CHECK: User ka is_admin field check karo
        if (isset($user->is_admin) && $user->is_admin == true) {
            return $next($request);
        }

        // If not admin, redirect to user dashboard
        return redirect()->route('account.dashboard')->with('error', 'Unauthorized access. Admin only.');
    }
}