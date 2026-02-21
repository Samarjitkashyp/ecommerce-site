<?php
// app/Http/Controllers/AccountController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class AccountController extends BaseController
{
    /**
     * Constructor - FIXED VERSION for Laravel 11/12
     */
    public function __construct()
    {
        // YEH LINE IMPORTANT HAI - middleware() method BaseController se aata hai
        $this->middleware('auth');
    }

    /**
     * Dashboard - Main Account Page
     */
    public function dashboard()
    {
        try {
            $user = auth()->user();
            
            // Agar user logged in nahi hai to redirect
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login first');
            }
            
            // Get counts with error handling
            $totalOrders = Order::where('user_id', $user->id)->count();
            $wishlistCount = Wishlist::where('user_id', $user->id)->count();
            $addressCount = Address::where('user_id', $user->id)->count();
            
            // Get recent orders with items
            $recentOrders = Order::with('items')
                ->where('user_id', $user->id)
                ->latest()
                ->limit(5)
                ->get();
            
            // Get pending orders count
            $pendingOrders = Order::where('user_id', $user->id)
                ->whereIn('order_status', ['pending', 'confirmed', 'processing'])
                ->count();
            
            // Get delivered orders count
            $deliveredOrders = Order::where('user_id', $user->id)
                ->where('order_status', 'delivered')
                ->count();
            
            // Get cancelled orders count
            $cancelledOrders = Order::where('user_id', $user->id)
                ->whereIn('order_status', ['cancelled', 'returned'])
                ->count();
            
            return view('account.dashboard', compact(
                'user',
                'totalOrders',
                'wishlistCount',
                'addressCount',
                'recentOrders',
                'pendingOrders',
                'deliveredOrders',
                'cancelledOrders'
            ));
            
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Profile Page
     */
    public function profile()
    {
        try {
            $user = auth()->user();
            return view('account.profile', compact('user'));
        } catch (\Exception $e) {
            Log::error('Profile page error: ' . $e->getMessage());
            return redirect()->route('account.dashboard')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|size:10|unique:users,phone,' . $user->id,
                'gender' => 'nullable|in:male,female,other',
                'dob' => 'nullable|date|before:today',
            ]);

            $user->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Profile updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }

    /**
     * Change Password
     */
    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required|current_password',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            auth()->user()->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password changed successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Password changed successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors());
            
        } catch (\Exception $e) {
            Log::error('Password change error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to change password.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to change password.');
        }
    }

    /**
     * Upload Avatar
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $user = auth()->user();
            
            // Create avatars directory if not exists
            if (!Storage::disk('public')->exists('avatars')) {
                Storage::disk('public')->makeDirectory('avatars');
            }
            
            // Delete old avatar
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Upload new avatar
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');

            $user->avatar = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar uploaded successfully!',
                'avatar_url' => $user->avatar_url
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Avatar upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload avatar.'
            ], 500);
        }
    }

    /**
     * Orders Page
     */
    public function orders()
    {
        try {
            $user = auth()->user();
            $orders = Order::with('items')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
            
            return view('account.orders', compact('orders'));
            
        } catch (\Exception $e) {
            Log::error('Orders page error: ' . $e->getMessage());
            return redirect()->route('account.dashboard')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Order Details
     */
    public function orderDetails($id)
    {
        try {
            $user = auth()->user();
            $order = Order::with(['items', 'address'])
                ->where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();
            
            return view('account.order-detail', compact('order'));
            
        } catch (\Exception $e) {
            Log::error('Order details error: ' . $e->getMessage());
            return redirect()->route('account.orders')->with('error', 'Order not found!');
        }
    }

    /**
     * Wishlist Page
     */
    public function wishlist()
    {
        try {
            $user = auth()->user();
            $wishlist = Wishlist::where('user_id', $user->id)->latest()->get();
            
            return view('account.wishlist', compact('wishlist'));
            
        } catch (\Exception $e) {
            Log::error('Wishlist page error: ' . $e->getMessage());
            return redirect()->route('account.dashboard')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Addresses Page
     */
    public function addresses()
    {
        try {
            $user = auth()->user();
            $addresses = Address::where('user_id', $user->id)->latest()->get();
            
            return view('account.addresses', compact('addresses'));
            
        } catch (\Exception $e) {
            Log::error('Addresses page error: ' . $e->getMessage());
            return redirect()->route('account.dashboard')->with('error', 'Something went wrong!');
        }
    }
}