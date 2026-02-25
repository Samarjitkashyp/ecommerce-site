<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductCategory;

/**
 * BASE ADMIN CONTROLLER
 * All admin controllers should extend this
 */
abstract class AdminController extends Controller
{
    /**
     * CONSTRUCTOR
     * Share common data with all admin views
     */
    public function __construct()
    {
        // Apply admin middleware
        $this->middleware('admin');
        
        // Share data with all admin views
        View::share('adminMenu', $this->getAdminMenu());
        View::share('quickStats', $this->getQuickStats());
    }

    /**
     * GET ADMIN SIDEBAR MENU
     */
    protected function getAdminMenu()
    {
        return [
            'dashboard' => [
                'name' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'admin.dashboard',
                'permission' => 'dashboard.view'
            ],
            'menus' => [
                'name' => 'Menu Management',
                'icon' => 'fas fa-bars',
                'route' => 'admin.menus.index',
                'permission' => 'menus.view',
                'submenu' => [
                    ['name' => 'All Menus', 'route' => 'admin.menus.index'],
                    ['name' => 'Add New', 'route' => 'admin.menus.create'],
                    ['name' => 'Menu Locations', 'route' => 'admin.menus.locations']
                ]
            ],
            'product-categories' => [
                'name' => 'Product Categories',
                'icon' => 'fas fa-tags',
                'route' => 'admin.product-categories.index',
                'permission' => 'categories.view',
                'submenu' => [
                    ['name' => 'All Categories', 'route' => 'admin.product-categories.index'],
                    ['name' => 'Add New', 'route' => 'admin.product-categories.create']
                ]
            ],
            'products' => [
                'name' => 'Products',
                'icon' => 'fas fa-box',
                'route' => 'admin.products.index',
                'permission' => 'products.view',
                'submenu' => [
                    ['name' => 'All Products', 'route' => 'admin.products.index'],
                    ['name' => 'Add New', 'route' => 'admin.products.create'],
                    ['name' => 'Inventory', 'route' => 'admin.products.inventory']
                ]
            ],
            'orders' => [
                'name' => 'Orders',
                'icon' => 'fas fa-shopping-cart',
                'route' => 'admin.orders.index',
                'permission' => 'orders.view',
                'submenu' => [
                    ['name' => 'All Orders', 'route' => 'admin.orders.index'],
                    ['name' => 'Pending', 'route' => 'admin.orders.pending'],
                    ['name' => 'Processing', 'route' => 'admin.orders.processing'],
                    ['name' => 'Completed', 'route' => 'admin.orders.completed'],
                    ['name' => 'Cancelled', 'route' => 'admin.orders.cancelled']
                ]
            ],
            'users' => [
                'name' => 'Users',
                'icon' => 'fas fa-users',
                'route' => 'admin.users.index',
                'permission' => 'users.view',
                'submenu' => [
                    ['name' => 'All Users', 'route' => 'admin.users.index'],
                    ['name' => 'Add New', 'route' => 'admin.users.create']
                ]
            ],
            'settings' => [
                'name' => 'Settings',
                'icon' => 'fas fa-cog',
                'route' => 'admin.settings',
                'permission' => 'settings.view',
                'submenu' => [
                    ['name' => 'General', 'route' => 'admin.settings.general'],
                    ['name' => 'SEO', 'route' => 'admin.settings.seo'],
                    ['name' => 'Payment', 'route' => 'admin.settings.payment'],
                    ['name' => 'Shipping', 'route' => 'admin.settings.shipping']
                ]
            ]
        ];
    }

    /**
     * 🔥 FIXED: GET QUICK STATS FOR DASHBOARD
     * Removed MySQL-specific SHOW TABLES query
     * Using Schema::hasTable() which works on all databases
     */
    protected function getQuickStats()
    {
        try {
            // Check if tables exist using Schema facade (works on all DBs)
            $categoryCount = 0;
            
            if (Schema::hasTable('product_categories')) {
                $categoryCount = ProductCategory::count();
            } elseif (Schema::hasTable('categories')) {
                $categoryCount = DB::table('categories')->count();
            }
            
            return [
                'total_orders' => Schema::hasTable('orders') ? Order::count() : 0,
                'pending_orders' => Schema::hasTable('orders') ? Order::where('order_status', 'pending')->count() : 0,
                'total_users' => Schema::hasTable('users') ? User::count() : 0,
                'total_products' => Schema::hasTable('products') ? DB::table('products')->count() : 0,
                'total_categories' => $categoryCount,
                'total_menus' => Schema::hasTable('menus') ? Menu::count() : 0
            ];
        } catch (\Exception $e) {
            return [
                'total_orders' => 0,
                'pending_orders' => 0,
                'total_users' => 0,
                'total_products' => 0,
                'total_categories' => 0,
                'total_menus' => 0
            ];
        }
    }

    /**
     * 🔥 REMOVED: getCategoryCount() method
     * Logic moved directly into getQuickStats()
     */

    /**
     * HANDLE SUCCESS RESPONSE
     */
    protected function sendSuccess($message, $data = [], $redirect = null)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'redirect' => $redirect
            ]);
        }

        if ($redirect) {
            return redirect($redirect)->with('success', $message);
        }

        return back()->with('success', $message);
    }

    /**
     * HANDLE ERROR RESPONSE
     */
    protected function sendError($message, $errors = [], $code = 422)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ], $code);
        }

        return back()->withErrors($errors)->with('error', $message)->withInput();
    }
}