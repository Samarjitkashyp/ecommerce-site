<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

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
            
            // 🔥 Get delivery charges from settings
            $deliverySettings = $this->getDeliverySettings();
            $deliveryCharge = $subtotal >= $deliverySettings['free_delivery_threshold'] ? 0 : $deliverySettings['standard_delivery_charge'];
            $tax = round($subtotal * $deliverySettings['tax_rate'] / 100);
            $total = $subtotal + $deliveryCharge + $tax;
            
            return view('front.checkout', compact('cart', 'addresses', 'subtotal', 'deliveryCharge', 'tax', 'total', 'deliverySettings'));
            
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

            $deliverySettings = $this->getDeliverySettings();
            $deliveryCharge = $this->calculateDeliveryCharge($subtotal, $validated['delivery_option'], $deliverySettings);
            $tax = round($subtotal * $deliverySettings['tax_rate'] / 100);
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
     * 🔥 FIXED: Get delivery settings from database or config
     */
    private function getDeliverySettings()
    {
        // Default settings
        $defaultSettings = [
            'standard_delivery_charge' => 40,
            'express_delivery_charge' => 99,
            'sameday_delivery_charge' => 199,
            'free_delivery_threshold' => 499,
            'tax_rate' => 5, // 5% GST
            'standard_delivery_days' => 5,
            'express_delivery_days' => 2,
            'sameday_delivery_cutoff' => '14:00'
        ];
        
        // If settings table exists, get from database
        if (Schema::hasTable('settings')) {
            try {
                $settings = DB::table('settings')->where('group', 'delivery')->pluck('value', 'key');
                
                if ($settings->isNotEmpty()) {
                    foreach ($settings as $key => $value) {
                        if (isset($defaultSettings[$key])) {
                            if (is_numeric($value)) {
                                $defaultSettings[$key] = (float)$value;
                            } else {
                                $defaultSettings[$key] = $value;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Could not load delivery settings: ' . $e->getMessage());
            }
        }
        
        return $defaultSettings;
    }

    /**
     * 🔥 FIXED: Calculate delivery charge based on settings
     */
    private function calculateDeliveryCharge($subtotal, $deliveryOption, $settings)
    {
        $charges = [
            'standard' => $settings['standard_delivery_charge'],
            'express' => $settings['express_delivery_charge'],
            'sameday' => $settings['sameday_delivery_charge']
        ];

        if ($deliveryOption == 'standard' && $subtotal >= $settings['free_delivery_threshold']) {
            return 0;
        }

        return $charges[$deliveryOption] ?? $settings['standard_delivery_charge'];
    }
}