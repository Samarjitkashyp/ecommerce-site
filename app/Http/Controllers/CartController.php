<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $savedForLater = Session::get('saved_for_later', []);
        $appliedCoupon = Session::get('applied_coupon');
        
        // Calculate totals
        $subtotal = 0;
        $deliveryCharge = 40;
        $tax = 0;
        $discount = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Free delivery on orders above ₹499
        if ($subtotal >= 499) {
            $deliveryCharge = 0;
        }
        
        // Tax calculation (5% GST)
        $tax = round($subtotal * 0.05);
        
        // Apply coupon discount if any
        if ($appliedCoupon) {
            if ($appliedCoupon['type'] == 'percentage') {
                $discount = round($subtotal * $appliedCoupon['value'] / 100);
            } else {
                $discount = $appliedCoupon['value'];
            }
        } else {
            $discount = round($subtotal * 0.1);
        }
        
        $total = $subtotal + $deliveryCharge + $tax - $discount;
        
        $suggestedProducts = $this->getSuggestedProducts($cart);
        
        return view('front.cart', compact(
            'cart', 
            'savedForLater', 
            'subtotal', 
            'deliveryCharge', 
            'tax', 
            'discount', 
            'total',
            'suggestedProducts',
            'appliedCoupon'
        ));
    }
    
    /**
     * Add item to cart - COMPLETELY FIXED
     */
    public function add(Request $request)
    {
        try {
            // Log request data for debugging
            Log::info('Add to cart request received:', $request->all());
            
            // Validate request
            $validated = $request->validate([
                'id' => 'required',
                'name' => 'required|string',
                'price' => 'required|numeric',
                'brand' => 'required|string',
                'image' => 'required|string',
                'quantity' => 'required|integer|min:1|max:10'
            ]);
            
            $cart = Session::get('cart', []);
            $productId = (string)$request->id;
            
            // Check if product already in cart
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += (int)$request->quantity;
                // Ensure quantity doesn't exceed max
                if ($cart[$productId]['quantity'] > 10) {
                    $cart[$productId]['quantity'] = 10;
                }
            } else {
                $cart[$productId] = [
                    'id' => $productId,
                    'name' => $request->name,
                    'brand' => $request->brand,
                    'price' => (float)$request->price,
                    'original_price' => $request->original_price ?? (float)$request->price,
                    'discount' => $request->discount ?? 0,
                    'image' => $request->image,
                    'quantity' => (int)$request->quantity,
                    'max_quantity' => 10,
                    'selected_size' => $request->selected_size ?? null,
                    'selected_color' => $request->selected_color ?? null,
                    'in_stock' => true,
                    'delivery_date' => now()->addDays(3)->format('d M')
                ];
            }
            
            Session::put('cart', $cart);
            Session::save();
            
            // Calculate total cart count
            $cartCount = 0;
            foreach ($cart as $item) {
                $cartCount += $item['quantity'];
            }
            
            Log::info('Cart updated successfully. New count: ' . $cartCount);
            
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully!',
                'cart_count' => $cartCount,
                'cart' => $cart,
                'redirect' => route('cart.index')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in add to cart:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error in add to cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding item to cart: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'quantity' => 'required|integer|min:1|max:10'
            ]);
            
            $cart = Session::get('cart', []);
            $productId = (string)$request->id;
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = (int)$request->quantity;
                Session::put('cart', $cart);
                Session::save();
                
                // Recalculate totals
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                
                $deliveryCharge = $subtotal < 499 ? 40 : 0;
                $tax = round($subtotal * 0.05);
                
                $appliedCoupon = Session::get('applied_coupon');
                if ($appliedCoupon) {
                    if ($appliedCoupon['type'] == 'percentage') {
                        $discount = round($subtotal * $appliedCoupon['value'] / 100);
                    } else {
                        $discount = $appliedCoupon['value'];
                    }
                } else {
                    $discount = round($subtotal * 0.1);
                }
                
                $total = $subtotal + $deliveryCharge + $tax - $discount;
                
                $itemTotal = $cart[$productId]['price'] * $cart[$productId]['quantity'];
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated!',
                    'item_total' => $itemTotal,
                    'item_total_formatted' => '₹' . number_format($itemTotal),
                    'subtotal' => $subtotal,
                    'subtotal_formatted' => '₹' . number_format($subtotal),
                    'delivery_charge' => $deliveryCharge,
                    'tax' => $tax,
                    'tax_formatted' => '₹' . number_format($tax),
                    'discount' => $discount,
                    'discount_formatted' => '₹' . number_format($discount),
                    'total' => $total,
                    'total_formatted' => '₹' . number_format($total),
                    'cart_count' => $cartCount
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Error in update cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating cart'
            ], 500);
        }
    }
    
    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            
            $cart = Session::get('cart', []);
            $productId = (string)$request->id;
            
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);
                Session::save();
                
                if (empty($cart)) {
                    Session::forget('applied_coupon');
                }
                
                // Recalculate totals
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                
                $deliveryCharge = $subtotal < 499 ? 40 : 0;
                $tax = round($subtotal * 0.05);
                
                $appliedCoupon = Session::get('applied_coupon');
                if ($appliedCoupon && !empty($cart)) {
                    if ($appliedCoupon['type'] == 'percentage') {
                        $discount = round($subtotal * $appliedCoupon['value'] / 100);
                    } else {
                        $discount = $appliedCoupon['value'];
                    }
                } else {
                    $discount = round($subtotal * 0.1);
                }
                
                $total = $subtotal + $deliveryCharge + $tax - $discount;
                
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart!',
                    'cart_empty' => empty($cart),
                    'cart_count' => $cartCount,
                    'subtotal' => $subtotal,
                    'subtotal_formatted' => '₹' . number_format($subtotal),
                    'delivery_charge' => $deliveryCharge,
                    'tax' => $tax,
                    'tax_formatted' => '₹' . number_format($tax),
                    'discount' => $discount,
                    'discount_formatted' => '₹' . number_format($discount),
                    'total' => $total,
                    'total_formatted' => '₹' . number_format($total)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Error in remove from cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error removing item'
            ], 500);
        }
    }
    
    /**
     * Move item to save for later
     */
    public function saveForLater(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            
            $cart = Session::get('cart', []);
            $saved = Session::get('saved_for_later', []);
            $productId = (string)$request->id;
            
            if (isset($cart[$productId])) {
                $saved[$productId] = $cart[$productId];
                unset($cart[$productId]);
                
                Session::put('cart', $cart);
                Session::put('saved_for_later', $saved);
                Session::save();
                
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Item saved for later!',
                    'cart_count' => $cartCount,
                    'saved_count' => count($saved)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Error in save for later: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving item'
            ], 500);
        }
    }
    
    /**
     * Move item from saved to cart
     */
    public function moveToCart(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            
            $cart = Session::get('cart', []);
            $saved = Session::get('saved_for_later', []);
            $productId = (string)$request->id;
            
            if (isset($saved[$productId])) {
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $saved[$productId]['quantity'];
                } else {
                    $cart[$productId] = $saved[$productId];
                }
                
                unset($saved[$productId]);
                
                Session::put('cart', $cart);
                Session::put('saved_for_later', $saved);
                Session::save();
                
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Item moved to cart!',
                    'cart_count' => $cartCount,
                    'saved_count' => count($saved)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Item not found in saved items'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Error in move to cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error moving item'
            ], 500);
        }
    }
    
    /**
     * Apply coupon
     */
    public function applyCoupon(Request $request)
    {
        try {
            $request->validate([
                'coupon' => 'required|string'
            ]);
            
            $coupon = strtoupper($request->coupon);
            
            $validCoupons = [
                'SAVE10' => ['value' => 10, 'type' => 'percentage', 'message' => '10% off'],
                'SAVE20' => ['value' => 20, 'type' => 'percentage', 'message' => '20% off'],
                'FLAT500' => ['value' => 500, 'type' => 'fixed', 'message' => '₹500 off'],
                'WELCOME50' => ['value' => 50, 'type' => 'fixed', 'message' => '₹50 off'],
                'FIRST100' => ['value' => 100, 'type' => 'fixed', 'message' => '₹100 off'],
                'FREEDEL' => ['value' => 40, 'type' => 'fixed', 'message' => 'Free Delivery'],
            ];
            
            if (isset($validCoupons[$coupon])) {
                $couponData = $validCoupons[$coupon];
                
                Session::put('applied_coupon', [
                    'code' => $coupon,
                    'value' => $couponData['value'],
                    'type' => $couponData['type'],
                    'message' => $couponData['message']
                ]);
                Session::save();
                
                $cart = Session::get('cart', []);
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                
                if ($couponData['type'] == 'percentage') {
                    $discount = round($subtotal * $couponData['value'] / 100);
                } else {
                    $discount = $couponData['value'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon applied successfully!',
                    'discount' => $discount,
                    'discount_formatted' => '₹' . number_format($discount),
                    'coupon_code' => $coupon,
                    'coupon_message' => $couponData['message']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code!'
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error in apply coupon: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error applying coupon'
            ], 500);
        }
    }
    
    /**
     * Remove coupon
     */
    public function removeCoupon(Request $request)
    {
        try {
            Session::forget('applied_coupon');
            Session::save();
            
            $cart = Session::get('cart', []);
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $deliveryCharge = $subtotal < 499 ? 40 : 0;
            $tax = round($subtotal * 0.05);
            $discount = round($subtotal * 0.1);
            $total = $subtotal + $deliveryCharge + $tax - $discount;
            
            return response()->json([
                'success' => true,
                'message' => 'Coupon removed!',
                'discount' => $discount,
                'discount_formatted' => '₹' . number_format($discount),
                'total' => $total,
                'total_formatted' => '₹' . number_format($total)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in remove coupon: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error removing coupon'
            ], 500);
        }
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        try {
            Session::forget('cart');
            Session::forget('saved_for_later');
            Session::forget('applied_coupon');
            Session::save();
            
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared!',
                'cart_count' => 0
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in clear cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cart'
            ], 500);
        }
    }
    
    /**
     * Get cart count
     */
    public function getCount()
    {
        try {
            $cart = Session::get('cart', []);
            $count = 0;
            foreach ($cart as $item) {
                $count += $item['quantity'];
            }
            
            return response()->json([
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in get count: ' . $e->getMessage());
            return response()->json([
                'count' => 0
            ]);
        }
    }
    
    /**
     * Get suggested products
     */
    private function getSuggestedProducts($cart)
    {
        $allProducts = [
            [
                'id' => 301,
                'name' => 'Wireless Mouse',
                'brand' => 'Logitech',
                'price' => 599,
                'original_price' => 999,
                'discount' => 40,
                'image' => 'https://picsum.photos/200/200?random=301',
                'rating' => 4.3,
                'reviews' => 2345,
                'slug' => 'wireless-mouse'
            ],
            [
                'id' => 302,
                'name' => 'Laptop Sleeve 13 inch',
                'brand' => 'Amazon Basics',
                'price' => 399,
                'original_price' => 799,
                'discount' => 50,
                'image' => 'https://picsum.photos/200/200?random=302',
                'rating' => 4.1,
                'reviews' => 1234,
                'slug' => 'laptop-sleeve'
            ],
            [
                'id' => 303,
                'name' => 'USB-C Cable 2m',
                'brand' => 'Anker',
                'price' => 299,
                'original_price' => 499,
                'discount' => 40,
                'image' => 'https://picsum.photos/200/200?random=303',
                'rating' => 4.5,
                'reviews' => 5678,
                'slug' => 'usb-c-cable'
            ],
            [
                'id' => 304,
                'name' => 'Power Bank 10000mAh',
                'brand' => 'MI',
                'price' => 1299,
                'original_price' => 1999,
                'discount' => 35,
                'image' => 'https://picsum.photos/200/200?random=304',
                'rating' => 4.4,
                'reviews' => 3456,
                'slug' => 'power-bank'
            ],
        ];
        
        return array_slice($allProducts, 0, 4);
    }
}