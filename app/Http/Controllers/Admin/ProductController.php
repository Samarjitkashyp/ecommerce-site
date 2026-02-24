<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends AdminController
{
    /**
     * ============================================
     * DISPLAY ALL PRODUCTS
     * Shows list of products with filters
     * ============================================
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Apply filters
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('status') && $request->status) {
            $isActive = $request->status === 'active' ? true : false;
            $query->where('is_active', $isActive);
        }
        
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }
        
        $products = $query->orderBy('sort_order')
                         ->orderBy('created_at', 'desc')
                         ->paginate(20);
        
        $categories = ProductCategory::active()->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * ============================================
     * SHOW CREATE FORM
     * All fields for product creation
     * ============================================
     */
    public function create()
    {
        $categories = ProductCategory::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Available badge options
        $badges = [
            '' => 'No Badge',
            'NEW' => 'New',
            'TRENDING' => 'Trending',
            'BESTSELLER' => 'Bestseller',
            'SALE' => 'Sale',
            'LIMITED' => 'Limited Edition'
        ];
        
        return view('admin.products.create', compact('categories', 'badges'));
    }

    /**
     * ============================================
     * STORE NEW PRODUCT
     * Save product with all dynamic fields
     * ============================================
     */

    /**
     * ============================================
     * TOGGLE PRODUCT STATUS
     * Activate/Deactivate product
     * ============================================
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->is_active = !$product->is_active;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Product status updated!',
                'is_active' => $product->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Product status toggle error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status'
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            // Validate request - All fields that appear on product page
            $validated = $request->validate([
                // Basic Info
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products',
                'brand' => 'required|string|max:255',
                'sku' => 'nullable|string|max:100|unique:products',
                
                // Category
                'category_id' => 'required|exists:product_categories,id',
                'subcategory' => 'nullable|string|max:255',
                
                // Pricing
                'price' => 'required|numeric|min:0',
                'original_price' => 'nullable|numeric|min:0|gte:price',
                'discount' => 'nullable|integer|min:0|max:100',
                
                // Content
                'description' => 'nullable|string',
                'highlights' => 'nullable|array',
                'highlights.*' => 'string',
                'specifications' => 'nullable|array',
                
                // Media - Main Image
                'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'thumbnail_images' => 'nullable|array',
                'thumbnail_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
                
                // Variants
                'colors' => 'nullable|array',
                'colors.*' => 'string',
                'sizes' => 'nullable|array',
                'sizes.*' => 'string',
                
                // Stock
                'in_stock' => 'boolean',
                'stock_quantity' => 'nullable|integer|min:0',
                'badge' => 'nullable|string|in:NEW,TRENDING,BESTSELLER,SALE,LIMITED',
                
                // Seller Info
                'seller' => 'nullable|string|max:255',
                'seller_rating' => 'nullable|numeric|min:0|max:5',
                'seller_ratings_count' => 'nullable|integer|min:0',
                'warranty' => 'nullable|string',
                
                // SEO
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
                
                // Status
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle images upload
            $images = [];
            
            // Upload main image
            if ($request->hasFile('main_image')) {
                $mainImagePath = $request->file('main_image')->store('products/main', 'public');
                $images['main'] = $mainImagePath;
            }
            
            // Upload thumbnail images
            if ($request->hasFile('thumbnail_images')) {
                $thumbnails = [];
                foreach ($request->file('thumbnail_images') as $index => $image) {
                    $path = $image->store('products/thumbnails', 'public');
                    $thumbnails[] = $path;
                }
                $images['thumbnails'] = $thumbnails;
            }
            
            $validated['images'] = $images;
            
            // Convert arrays to JSON
            $validated['highlights'] = $request->highlights ? json_encode($request->highlights) : null;
            $validated['specifications'] = $this->formatSpecifications($request->specifications);
            $validated['colors'] = $request->colors ? json_encode($request->colors) : null;
            $validated['sizes'] = $request->sizes ? json_encode($request->sizes) : null;
            
            // Set boolean fields
            $validated['in_stock'] = $request->boolean('in_stock', true);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);
            
            // Auto-calculate discount if not provided
            if (empty($validated['discount']) && !empty($validated['original_price']) && $validated['original_price'] > $validated['price']) {
                $validated['discount'] = round((($validated['original_price'] - $validated['price']) / $validated['original_price']) * 100);
            }
            
            // Create product
            $product = Product::create($validated);
            
            Log::info('Product created by admin', ['product_id' => $product->id, 'name' => $product->name]);
            
            return $this->sendSuccess(
                'Product created successfully!',
                ['product' => $product],
                route('admin.products.index')
            );
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Product creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create product: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * ============================================
     * SHOW EDIT FORM
     * Edit existing product with all fields
     * ============================================
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        $badges = [
            '' => 'No Badge',
            'NEW' => 'New',
            'TRENDING' => 'Trending',
            'BESTSELLER' => 'Bestseller',
            'SALE' => 'Sale',
            'LIMITED' => 'Limited Edition'
        ];
        
        return view('admin.products.edit', compact('product', 'categories', 'badges'));
    }

    /**
     * ============================================
     * UPDATE PRODUCT
     * Update existing product
     * ============================================
     */
    public function update(Request $request, Product $product)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
                'brand' => 'required|string|max:255',
                'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
                'category_id' => 'required|exists:product_categories,id',
                'subcategory' => 'nullable|string|max:255',
                'price' => 'required|numeric|min:0',
                'original_price' => 'nullable|numeric|min:0|gte:price',
                'discount' => 'nullable|integer|min:0|max:100',
                'description' => 'nullable|string',
                'highlights' => 'nullable|array',
                'highlights.*' => 'string',
                'specifications' => 'nullable|array',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'thumbnail_images' => 'nullable|array',
                'thumbnail_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
                'remove_images' => 'nullable|array',
                'colors' => 'nullable|array',
                'colors.*' => 'string',
                'sizes' => 'nullable|array',
                'sizes.*' => 'string',
                'in_stock' => 'boolean',
                'stock_quantity' => 'nullable|integer|min:0',
                'badge' => 'nullable|string|in:NEW,TRENDING,BESTSELLER,SALE,LIMITED',
                'seller' => 'nullable|string|max:255',
                'seller_rating' => 'nullable|numeric|min:0|max:5',
                'seller_ratings_count' => 'nullable|integer|min:0',
                'warranty' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle images
            $images = $product->images ?? [];
            
            // Remove images if requested
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageToRemove) {
                    if (isset($images[$imageToRemove])) {
                        Storage::disk('public')->delete($images[$imageToRemove]);
                        unset($images[$imageToRemove]);
                    }
                }
            }
            
            // Upload new main image
            if ($request->hasFile('main_image')) {
                // Delete old main image
                if (isset($images['main'])) {
                    Storage::disk('public')->delete($images['main']);
                }
                $mainImagePath = $request->file('main_image')->store('products/main', 'public');
                $images['main'] = $mainImagePath;
            }
            
            // Upload new thumbnail images
            if ($request->hasFile('thumbnail_images')) {
                $thumbnails = $images['thumbnails'] ?? [];
                foreach ($request->file('thumbnail_images') as $image) {
                    $path = $image->store('products/thumbnails', 'public');
                    $thumbnails[] = $path;
                }
                $images['thumbnails'] = $thumbnails;
            }
            
            $validated['images'] = $images;
            
            // Convert arrays to JSON
            $validated['highlights'] = $request->highlights ? json_encode($request->highlights) : null;
            $validated['specifications'] = $this->formatSpecifications($request->specifications);
            $validated['colors'] = $request->colors ? json_encode($request->colors) : null;
            $validated['sizes'] = $request->sizes ? json_encode($request->sizes) : null;
            
            // Set boolean fields
            $validated['in_stock'] = $request->boolean('in_stock', true);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);
            
            // Auto-calculate discount if needed
            if (empty($validated['discount']) && !empty($validated['original_price']) && $validated['original_price'] > $validated['price']) {
                $validated['discount'] = round((($validated['original_price'] - $validated['price']) / $validated['original_price']) * 100);
            }
            
            // Update product
            $product->update($validated);
            
            Log::info('Product updated by admin', ['product_id' => $product->id, 'name' => $product->name]);
            
            return $this->sendSuccess(
                'Product updated successfully!',
                ['product' => $product],
                route('admin.products.index')
            );
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Product update error: ' . $e->getMessage());
            return $this->sendError('Failed to update product: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * ============================================
     * DELETE PRODUCT
     * Soft delete with images cleanup
     * ============================================
     */
    public function destroy(Product $product)
    {
        try {
            $productName = $product->name;
            
            // Soft delete (images will remain, but can be cleaned up later)
            $product->delete();
            
            Log::info('Product deleted', ['product_id' => $product->id, 'name' => $productName]);
            
            return response()->json([
                'success' => true,
                'message' => 'Product "' . $productName . '" deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Product deletion error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ============================================
     * INVENTORY PAGE
     * Manage stock levels
     * ============================================
     */
    public function inventory()
    {
        $products = Product::select('id', 'name', 'brand', 'sku', 'stock_quantity', 'in_stock', 'price')
            ->orderBy('name')
            ->paginate(20);
        
        return view('admin.products.inventory', compact('products'));
    }

    /**
     * ============================================
     * UPDATE STOCK
     * Bulk update stock levels
     * ============================================
     */
    public function updateStock(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'stock_quantity' => 'required|integer|min:0',
                'in_stock' => 'boolean'
            ]);
            
            $product = Product::findOrFail($request->product_id);
            $product->stock_quantity = $request->stock_quantity;
            $product->in_stock = $request->boolean('in_stock', $request->stock_quantity > 0);
            $product->save();
            
            Log::info('Stock updated by admin', [
                'product_id' => $product->id,
                'stock_quantity' => $product->stock_quantity
            ]);
            
            return $this->sendSuccess('Stock updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Stock update error: ' . $e->getMessage());
            return $this->sendError('Failed to update stock', [], 500);
        }
    }

    /**
     * ============================================
     * FORMAT SPECIFICATIONS
     * Convert specifications array to JSON
     * ============================================
     */
    private function formatSpecifications($specs)
    {
        if (empty($specs)) {
            return null;
        }
        
        // Agar key-value pairs hain to waise hi rakho
        // Ya agar simple array hai to convert karo
        $formatted = [];
        foreach ($specs as $key => $value) {
            if (is_numeric($key)) {
                // Simple array hai
                $formatted[] = $value;
            } else {
                // Key-value pair hai
                $formatted[$key] = $value;
            }
        }
        
        return json_encode($formatted);
    }
}