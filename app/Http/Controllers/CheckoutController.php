<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout page with user's addresses
     */
    public function index()
    {
        try {
            $cart = Session::get('cart', []);
            
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
            }

            // Get user's addresses from database
            $addresses = auth()->user()->addresses()->latest()->get();
            
            // Calculate subtotal
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $deliveryCharge = $subtotal >= 499 ? 0 : 40;
            $tax = round($subtotal * 0.05);
            $total = $subtotal + $deliveryCharge + $tax;
            
            return view('front.checkout', compact('cart', 'addresses', 'subtotal', 'deliveryCharge', 'tax', 'total'));
            
        } catch (\Exception $e) {
            Log::error('Checkout page error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Process order and save to database
     */
    public function process(Request $request)
    {
        try {
            // Validate request first
            $validated = $request->validate([
                'address_id' => 'required|exists:addresses,id',
                'payment_method' => 'required|in:upi,card,netbanking,cod',
                'delivery_option' => 'required|in:standard,express,sameday',
                'notes' => 'nullable|string|max:500'
            ]);

            // Start transaction
            DB::beginTransaction();

            $cart = Session::get('cart', []);
            
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty!'
                ], 400);
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $validated['delivery_option']);
            $tax = round($subtotal * 0.05);
            $total = $subtotal + $deliveryCharge + $tax;

            // Generate unique order number
            $orderNumber = 'ORD-' . time() . '-' . rand(1000, 9999);

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'address_id' => $validated['address_id'],
                'subtotal' => $subtotal,
                'delivery_charge' => $deliveryCharge,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'notes' => $request->notes ?? null
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_brand' => $item['brand'],
                    'product_image' => $item['image'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'selected_size' => $item['selected_size'] ?? null,
                    'selected_color' => $item['selected_color'] ?? null,
                    'total' => $item['price'] * $item['quantity']
                ]);
            }

            // Clear cart
            Session::forget('cart');
            Session::forget('applied_coupon');
            Session::save();

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $orderNumber,
                'redirect' => route('account.orders')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order processing error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.'
            ], 500);
        }
    }

    /**
     * Calculate delivery charge
     */
    private function calculateDeliveryCharge($subtotal, $deliveryOption)
    {
        $charges = [
            'standard' => 40,
            'express' => 99,
            'sameday' => 199
        ];

        if ($deliveryOption == 'standard' && $subtotal >= 499) {
            return 0;
        }

        return $charges[$deliveryOption] ?? 40;
    }
}