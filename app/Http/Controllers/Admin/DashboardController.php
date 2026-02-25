<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductCategory;
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
            'total_categories' => ProductCategory::count(),
            'total_menus' => Menu::count(),
            'order_growth' => $this->calculateGrowth(Order::class, 'created_at'),
            'revenue_growth' => $this->calculateRevenueGrowth(),
            'user_growth' => $this->calculateGrowth(User::class, 'created_at'),
            'new_categories' => ProductCategory::where('created_at', '>=', now()->subWeek())->count()
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

        // 🔥 FIXED: Get monthly revenue for chart
        $monthlyRevenue = Order::where('payment_status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare chart data
        $chartLabels = [];
        $chartData = [];
        
        // Month names
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // Initialize with zeros
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i-1];
            $chartData[$i] = 0;
        }
        
        // Fill with actual data
        foreach ($monthlyRevenue as $item) {
            $chartData[$item->month] = (float)$item->revenue;
        }
        
        // Convert to indexed array
        $chartData = array_values($chartData);

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'orderStatus',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * GET DASHBOARD STATISTICS (AJAX)
     */
    public function getStats(Request $request)
    {
        $period = $request->get('period', '30');
        $dates = $this->getDateRange($period);

        $stats = [
            'orders' => Order::whereBetween('created_at', [$dates['start'], $dates['end']])->count(),
            'revenue' => Order::where('payment_status', 'completed')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->sum('total'),
            'users' => User::whereBetween('created_at', [$dates['start'], $dates['end']])->count(),
        ];

        // 🔥 FIXED: Get chart data for selected period
        $chartData = $this->getChartData($period, $dates);

        return response()->json([
            'success' => true,
            'data' => array_merge($stats, $chartData)
        ]);
    }

    /**
     * 🔥 NEW: Calculate growth percentage
     */
    private function calculateGrowth($model, $dateField)
    {
        $currentPeriod = $model::where($dateField, '>=', now()->subMonth())->count();
        $previousPeriod = $model::whereBetween($dateField, [now()->subMonths(2), now()->subMonth()])->count();
        
        if ($previousPeriod == 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }
        
        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100);
    }

    /**
     * 🔥 NEW: Calculate revenue growth
     */
    private function calculateRevenueGrowth()
    {
        $currentRevenue = Order::where('payment_status', 'completed')
            ->where('created_at', '>=', now()->subMonth())
            ->sum('total');
            
        $previousRevenue = Order::where('payment_status', 'completed')
            ->whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])
            ->sum('total');
            
        if ($previousRevenue == 0) {
            return $currentRevenue > 0 ? 100 : 0;
        }
        
        return round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100);
    }

    /**
     * 🔥 NEW: Get chart data for period
     */
    private function getChartData($period, $dates)
    {
        $data = [];
        $labels = [];
        
        if ($period <= 30) {
            // Daily data for last 30 days
            $results = Order::where('payment_status', 'completed')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total) as revenue')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
                
            foreach ($results as $result) {
                $labels[] = \Carbon\Carbon::parse($result->date)->format('d M');
                $data[] = (float)$result->revenue;
            }
        } else {
            // Monthly data
            for ($i = 0; $i < 12; $i++) {
                $month = now()->subMonths(11 - $i);
                $labels[] = $month->format('M');
                
                $revenue = Order::where('payment_status', 'completed')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total');
                    
                $data[] = (float)$revenue;
            }
        }
        
        return [
            'labels' => $labels,
            'revenue' => $data
        ];
    }

    /**
     * GET DATE RANGE FOR STATISTICS
     */
    private function getDateRange($period)
    {
        $now = now();

        switch ($period) {
            case '7':
                return [
                    'start' => $now->copy()->subDays(7)->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
            case '30':
                return [
                    'start' => $now->copy()->subDays(30)->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
            case '90':
                return [
                    'start' => $now->copy()->subDays(90)->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
            case '365':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear()
                ];
            default:
                return [
                    'start' => $now->copy()->subDays((int)$period)->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
        }
    }
}