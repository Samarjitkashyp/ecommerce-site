<?php
// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlist = auth()->user()->wishlists()->latest()->get();
        return view('account.wishlist', compact('wishlist'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required',
                'product_name' => 'required|string',
                'product_brand' => 'required|string',
                'price' => 'required|numeric',
                'product_image' => 'required|string',
            ]);

            $validated['user_id'] = auth()->id();

            // Check if already exists
            $exists = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $validated['product_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in wishlist!'
                ], 400);
            }

            Wishlist::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Added to wishlist!'
            ]);

        } catch (\Exception $e) {
            Log::error('Add to wishlist error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add to wishlist.'
            ], 500);
        }
    }

    public function destroy(Wishlist $wishlist)
    {
        try {
            if ($wishlist->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $wishlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist!'
            ]);

        } catch (\Exception $e) {
            Log::error('Remove from wishlist error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove from wishlist.'
            ], 500);
        }
    }

    public function moveToCart(Request $request, Wishlist $wishlist)
    {
        try {
            if ($wishlist->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Add to cart logic here (using existing cart system)
            $cart = Session::get('cart', []);
            
            $cart[$wishlist->product_id] = [
                'id' => $wishlist->product_id,
                'name' => $wishlist->product_name,
                'brand' => $wishlist->product_brand,
                'price' => $wishlist->price,
                'image' => $wishlist->product_image,
                'quantity' => 1,
            ];

            Session::put('cart', $cart);
            
            // Remove from wishlist
            $wishlist->delete();

            return response()->json([
                'success' => true,
                'message' => 'Moved to cart successfully!',
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            Log::error('Move to cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to move to cart.'
            ], 500);
        }
    }
}