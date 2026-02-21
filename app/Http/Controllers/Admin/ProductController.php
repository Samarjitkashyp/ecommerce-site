<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends AdminController
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = []; // Will be replaced with actual model
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show form to create new product
     */
    public function create()
    {
        $categories = []; // Will fetch from Category model
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|unique:products,sku',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
            ]);

            Log::info('Product created by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('Product created successfully!', [], route('admin.products.index'));
            
        } catch (\Exception $e) {
            Log::error('Product creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create product', [], 500);
        }
    }

    /**
     * Show form to edit product
     */
    public function edit($id)
    {
        $product = null; // Will fetch from model
        $categories = [];
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|unique:products,sku,' . $id,
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
            ]);

            Log::info('Product updated by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('Product updated successfully!', [], route('admin.products.index'));
            
        } catch (\Exception $e) {
            Log::error('Product update error: ' . $e->getMessage());
            return $this->sendError('Failed to update product', [], 500);
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy($id)
    {
        try {
            Log::info('Product deleted by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('Product deleted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Product deletion error: ' . $e->getMessage());
            return $this->sendError('Failed to delete product', [], 500);
        }
    }

    /**
     * Show inventory page
     */
    public function inventory()
    {
        $products = []; // Will fetch from model with stock info
        
        return view('admin.products.inventory', compact('products'));
    }

    /**
     * Update stock levels
     */
    public function updateStock(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'stock' => 'required|integer|min:0',
            ]);

            Log::info('Stock updated by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('Stock updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Stock update error: ' . $e->getMessage());
            return $this->sendError('Failed to update stock', [], 500);
        }
    }
}