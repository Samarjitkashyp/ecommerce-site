<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class DashboardController extends AdminController
{
    /**
     * SHOW ADMIN DASHBOARD
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total'),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_menus' => Menu::count(),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Get order status distribution
        $orderStatus = Order::select('order_status', DB::raw('count(*) as total'))
            ->groupBy('order_status')
            ->get();

        // Get monthly revenue
        $monthlyRevenue = Order::where('payment_status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'orderStatus',
            'monthlyRevenue'
        ));
    }

    /**
     * GET DASHBOARD STATISTICS (AJAX)
     */
    public function getStats(Request $request)
    {
        $period = $request->get('period', 'today');

        // Calculate date range based on period
        $dates = $this->getDateRange($period);

        $stats = [
            'orders' => Order::whereBetween('created_at', [$dates['start'], $dates['end']])->count(),
            'revenue' => Order::where('payment_status', 'completed')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->sum('total'),
            'users' => User::whereBetween('created_at', [$dates['start'], $dates['end']])->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * GET DATE RANGE FOR STATISTICS
     */
    private function getDateRange($period)
    {
        $now = now();

        switch ($period) {
            case 'today':
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
            case 'week':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek()
                ];
            case 'month':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
            case 'year':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear()
                ];
            default:
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
        }
    }
}