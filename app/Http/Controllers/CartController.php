<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $deliveryCharge = 40; // Default delivery charge
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
            // Default 10% discount for demo
            $discount = round($subtotal * 0.1);
        }
        
        $total = $subtotal + $deliveryCharge + $tax - $discount;
        
        // Suggested products (based on cart items)
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
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'brand' => 'required',
            'image' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        $productId = $request->id;
        
        // Check if product already in cart
        if (isset($cart[$productId])) {
            // Update quantity
            $cart[$productId]['quantity'] += $request->quantity;
        } else {
            // Add new item
            $cart[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'brand' => $request->brand,
                'price' => $request->price,
                'original_price' => $request->original_price ?? $request->price,
                'discount' => $request->discount ?? 0,
                'image' => $request->image,
                'quantity' => $request->quantity,
                'max_quantity' => $request->max_quantity ?? 10,
                'selected_size' => $request->selected_size ?? null,
                'selected_color' => $request->selected_color ?? null,
                'in_stock' => $request->in_stock ?? true,
                'delivery_date' => now()->addDays(3)->format('d M')
            ];
        }
        
        Session::put('cart', $cart);
        
        // Calculate new cart count
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully!',
                'cart_count' => $cartCount,
                'cart' => $cart
            ]);
        }
        
        return redirect()->back()->with('success', 'Item added to cart!');
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1|max:10'
        ]);
        
        $cart = Session::get('cart', []);
        $productId = $request->id;
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            
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
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }
    
    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        
        $cart = Session::get('cart', []);
        $productId = $request->id;
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            
            // If cart becomes empty, remove coupon
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
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_empty' => empty($cart),
                'cart_count' => array_sum(array_column($cart, 'quantity')),
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
    }
    
    /**
     * Move item to save for later
     */
    public function saveForLater(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        
        $cart = Session::get('cart', []);
        $saved = Session::get('saved_for_later', []);
        $productId = $request->id;
        
        if (isset($cart[$productId])) {
            // Move to saved
            $saved[$productId] = $cart[$productId];
            unset($cart[$productId]);
            
            Session::put('cart', $cart);
            Session::put('saved_for_later', $saved);
            
            return response()->json([
                'success' => true,
                'message' => 'Item saved for later!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'saved_count' => count($saved)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }
    
    /**
     * Move item from saved to cart
     */
    public function moveToCart(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        
        $cart = Session::get('cart', []);
        $saved = Session::get('saved_for_later', []);
        $productId = $request->id;
        
        if (isset($saved[$productId])) {
            // Check if already in cart
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $saved[$productId]['quantity'];
            } else {
                $cart[$productId] = $saved[$productId];
            }
            
            unset($saved[$productId]);
            
            Session::put('cart', $cart);
            Session::put('saved_for_later', $saved);
            
            return response()->json([
                'success' => true,
                'message' => 'Item moved to cart!',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'saved_count' => count($saved)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found in saved items'
        ], 404);
    }
    
    /**
     * Apply coupon
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string'
        ]);
        
        $coupon = strtoupper($request->coupon);
        
        // Demo coupons
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
            
            // Store coupon in session
            Session::put('applied_coupon', [
                'code' => $coupon,
                'value' => $couponData['value'],
                'type' => $couponData['type'],
                'message' => $couponData['message']
            ]);
            
            // Recalculate totals with new coupon
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
    }
    
    /**
     * Remove coupon
     */
    public function removeCoupon(Request $request)
    {
        Session::forget('applied_coupon');
        
        // Recalculate totals
        $cart = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryCharge = $subtotal < 499 ? 40 : 0;
        $tax = round($subtotal * 0.05);
        $discount = round($subtotal * 0.1); // Default discount
        $total = $subtotal + $deliveryCharge + $tax - $discount;
        
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed!',
            'discount' => $discount,
            'discount_formatted' => '₹' . number_format($discount),
            'total' => $total,
            'total_formatted' => '₹' . number_format($total)
        ]);
    }
    
    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        Session::forget('saved_for_later');
        Session::forget('applied_coupon');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared!',
            'cart_count' => 0
        ]);
    }
    
    /**
     * Get cart count
     */
    public function getCount()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        
        return response()->json([
            'count' => $count
        ]);
    }
    
    /**
     * Get suggested products based on cart
     */
    private function getSuggestedProducts($cart)
    {
        // Sample suggested products
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
            [
                'id' => 305,
                'name' => 'Screen Guard',
                'brand' => 'GadgetShield',
                'price' => 199,
                'original_price' => 399,
                'discount' => 50,
                'image' => 'https://picsum.photos/200/200?random=305',
                'rating' => 4.0,
                'reviews' => 890,
                'slug' => 'screen-guard'
            ],
            [
                'id' => 306,
                'name' => 'Mobile Stand',
                'brand' => 'Portronics',
                'price' => 299,
                'original_price' => 599,
                'discount' => 50,
                'image' => 'https://picsum.photos/200/200?random=306',
                'rating' => 4.2,
                'reviews' => 1678,
                'slug' => 'mobile-stand'
            ],
            [
                'id' => 307,
                'name' => 'Bluetooth Speaker',
                'brand' => 'JBL',
                'price' => 1999,
                'original_price' => 2999,
                'discount' => 33,
                'image' => 'https://picsum.photos/200/200?random=307',
                'rating' => 4.6,
                'reviews' => 7890,
                'slug' => 'bluetooth-speaker'
            ],
            [
                'id' => 308,
                'name' => 'HDMI Cable 1.5m',
                'brand' => 'Amazon Basics',
                'price' => 299,
                'original_price' => 499,
                'discount' => 40,
                'image' => 'https://picsum.photos/200/200?random=308',
                'rating' => 4.3,
                'reviews' => 2341,
                'slug' => 'hdmi-cable'
            ],
        ];
        
        // If cart is empty, return random products
        if (empty($cart)) {
            return array_slice($allProducts, 0, 4);
        }
        
        // Return first 4 products as suggestions
        return array_slice($allProducts, 0, 4);
    }
}