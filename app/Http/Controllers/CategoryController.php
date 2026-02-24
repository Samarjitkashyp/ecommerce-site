<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

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
        
        // Get products in this category (including subcategories)
        $categoryIds = $this->getCategoryAndChildrenIds($categoryInfo->id);
        
        $products = Product::with('category')
            ->whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(24);
        
        // 🔥 FIXED: Get ALL categories for filter sidebar (top level categories)
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
     * Get category ID and all children IDs
     */
    private function getCategoryAndChildrenIds($categoryId)
    {
        $ids = [$categoryId];
        
        $children = ProductCategory::where('parent_id', $categoryId)
            ->where('is_active', true)
            ->get();
        
        foreach ($children as $child) {
            $ids[] = $child->id;
            // Recursive for deeper levels
            $grandChildren = $this->getCategoryAndChildrenIds($child->id);
            $ids = array_merge($ids, $grandChildren);
        }
        
        return array_unique($ids);
    }
}