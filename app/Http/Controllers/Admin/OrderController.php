<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated; // Create this mail class

class OrderController extends AdminController
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show pending orders
     */
    public function pending()
    {
        $orders = Order::with('user')
            ->where('order_status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.orders.pending', compact('orders'));
    }

    /**
     * Show processing orders
     */
    public function processing()
    {
        $orders = Order::with('user')
            ->where('order_status', 'processing')
            ->latest()
            ->paginate(20);

        return view('admin.orders.processing', compact('orders'));
    }

    /**
     * Show completed orders
     */
    public function completed()
    {
        $orders = Order::with('user')
            ->where('order_status', 'completed')
            ->latest()
            ->paginate(20);

        return view('admin.orders.completed', compact('orders'));
    }

    /**
     * Show cancelled orders
     */
    public function cancelled()
    {
        $orders = Order::with('user')
            ->where('order_status', 'cancelled')
            ->latest()
            ->paginate(20);

        return view('admin.orders.cancelled', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load('user', 'items', 'address');
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * 🔥 FIXED: Update order status with email notification
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'order_status' => 'required|in:pending,processing,completed,cancelled'
            ]);

            $oldStatus = $order->order_status;
            $order->order_status = $request->order_status;
            
            if ($request->order_status == 'completed') {
                $order->delivered_at = now();
            }
            
            $order->save();

            Log::info('Order status updated', [
                'order_id' => $order->id, 
                'old_status' => $oldStatus,
                'new_status' => $order->order_status
            ]);

            // 🔥 Send email notification to customer
            try {
                if (class_exists('App\Mail\OrderStatusUpdated')) {
                    Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $oldStatus));
                }
            } catch (\Exception $e) {
                Log::warning('Order status email failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Order status update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status'
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
    {
        try {
            $order->order_status = 'cancelled';
            $order->save();

            // 🔥 Send cancellation email
            try {
                if (class_exists('App\Mail\OrderCancelled')) {
                    Mail::to($order->user->email)->send(new OrderCancelled($order));
                }
            } catch (\Exception $e) {
                Log::warning('Order cancellation email failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Order cancellation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order'
            ], 500);
        }
    }

    /**
     * Generate invoice
     */
    public function invoice(Order $order)
    {
        $order->load('user', 'items', 'address');
        
        return view('admin.orders.invoice', compact('order'));
    }
}