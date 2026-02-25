<?php
// app/Http/Controllers/Admin/SearchController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;  // 🔥 FIXED: Category -> ProductCategory

class SearchController extends AdminController
{
    /**
     * Global search in admin panel
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('admin.dashboard');
        }
        
        $results = [
            'users' => User::where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhere('phone', 'LIKE', "%{$query}%")
                        ->limit(5)
                        ->get(),
                        
            'orders' => Order::where('order_number', 'LIKE', "%{$query}%")
                        ->orWhereHas('user', function($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })
                        ->with('user')
                        ->limit(5)
                        ->get(),
                        
            // 🔥 FIXED: Category -> ProductCategory
            'categories' => ProductCategory::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->limit(5)
                            ->get(),
        ];
        
        // Product model agar hai to
        if (class_exists('App\Models\Product')) {
            $results['products'] = Product::where('name', 'LIKE', "%{$query}%")
                                    ->orWhere('sku', 'LIKE', "%{$query}%")
                                    ->orWhere('description', 'LIKE', "%{$query}%")
                                    ->limit(5)
                                    ->get();
        }
        
        return view('admin.search.results', compact('query', 'results'));
    }
}