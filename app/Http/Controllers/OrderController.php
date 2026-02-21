<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);
            
        return view('account.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        // Check ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items', 'address');
        
        return view('account.order-detail', compact('order'));
    }

    public function cancel(Order $order)
    {
        try {
            if ($order->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Check if order can be cancelled
            if (!in_array($order->order_status, ['pending', 'confirmed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order cannot be cancelled at this stage.'
                ], 400);
            }

            $order->order_status = 'cancelled';
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel order error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order.'
            ], 500);
        }
    }

    public function track(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('account.track-order', compact('order'));
    }
}