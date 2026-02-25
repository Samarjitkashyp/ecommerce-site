<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display the specified category page - DYNAMIC FROM DATABASE
     *
     * @param string $category (slug)
     * @return \Illuminate\View\View
     */
    public function show($category)
    {
        // Get current category from database by slug
        $categoryInfo = ProductCategory::where('slug', $category)
            ->where('is_active', true)
            ->firstOrFail();
        
        // 🔥 OPTIMIZED: Get category and all children IDs using caching
        $categoryIds = $this->getCategoryAndChildrenIdsOptimized($categoryInfo->id);
        
        $products = Product::with('category')
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(24);
        
        // Get ALL categories for filter sidebar (top level categories)
        $allCategories = ProductCategory::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Get subcategories of current category for additional filtering
        $subcategories = ProductCategory::where('parent_id', $categoryInfo->id)
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Get all brands in this category for filter
        $brands = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');
        
        return view('front.category', compact(
            'categoryInfo', 
            'products', 
            'allCategories',
            'subcategories',
            'brands'
        ));
    }
    
    /**
     * 🔥 OPTIMIZED: Get category ID and all children IDs without recursion
     * Using iteration instead of recursion for better performance
     */
    private function getCategoryAndChildrenIdsOptimized($categoryId)
    {
        // Try to get from cache first
        $cacheKey = 'category_children_' . $categoryId;
        
        return Cache::remember($cacheKey, 3600, function() use ($categoryId) {
            $ids = [$categoryId];
            $queue = [$categoryId];
            
            while (!empty($queue)) {
                $currentId = array_shift($queue);
                
                $children = ProductCategory::where('parent_id', $currentId)
                    ->where('is_active', true)
                    ->pluck('id')
                    ->toArray();
                
                foreach ($children as $childId) {
                    if (!in_array($childId, $ids)) {
                        $ids[] = $childId;
                        $queue[] = $childId;
                    }
                }
            }
            
            return $ids;
        });
    }
    
    /**
     * Keep old method for backward compatibility
     */
    private function getCategoryAndChildrenIds($categoryId)
    {
        return $this->getCategoryAndChildrenIdsOptimized($categoryId);
    }
}