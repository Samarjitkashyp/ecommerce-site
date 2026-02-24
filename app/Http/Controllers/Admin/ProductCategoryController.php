<?php
// app/Http/Controllers/Admin/ProductCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends AdminController
{
    /**
     * DISPLAY ALL CATEGORIES
     */
    public function index()
    {
        $categories = ProductCategory::with('parent')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.product-categories.index', compact('categories'));
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.product-categories.create', compact('parentCategories'));
    }

    /**
     * STORE NEW CATEGORY
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:product_categories',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:product_categories,id',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'sometimes|boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('product-categories', 'public');
                $validated['image'] = $path;
            }

            // Auto generate slug
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            // Set sort order
            if (empty($validated['sort_order'])) {
                $maxOrder = ProductCategory::max('sort_order') ?? 0;
                $validated['sort_order'] = $maxOrder + 1;
            }

            // Set is_active
            $validated['is_active'] = $request->has('is_active');

            // Create category
            $category = ProductCategory::create($validated);

            return $this->sendSuccess(
                'Product category created successfully!',
                ['category' => $category],
                route('admin.product-categories.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Product category creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create category: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit(ProductCategory $productCategory)
    {
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $productCategory->id)
            ->orderBy('name')
            ->get();

        return view('admin.product-categories.edit', compact('productCategory', 'parentCategories'));
    }

    /**
     * UPDATE CATEGORY
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $productCategory->id,
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:product_categories,id',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'sometimes|boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($productCategory->image) {
                    Storage::disk('public')->delete($productCategory->image);
                }
                
                $path = $request->file('image')->store('product-categories', 'public');
                $validated['image'] = $path;
            }

            // Handle image removal
            if ($request->has('remove_image')) {
                if ($productCategory->image) {
                    Storage::disk('public')->delete($productCategory->image);
                }
                $validated['image'] = null;
            }

            // Auto generate slug if empty
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            // Set is_active
            $validated['is_active'] = $request->has('is_active');

            // Update category
            $productCategory->update($validated);

            return $this->sendSuccess(
                'Product category updated successfully!',
                ['category' => $productCategory],
                route('admin.product-categories.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Product category update error: ' . $e->getMessage());
            return $this->sendError('Failed to update category: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * DELETE CATEGORY
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            // Check if has children
            if ($productCategory->children()->count() > 0) {
                return $this->sendError('Cannot delete category with subcategories. Delete subcategories first.');
            }

            // Delete image
            if ($productCategory->image) {
                Storage::disk('public')->delete($productCategory->image);
            }

            $categoryName = $productCategory->name;
            $productCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category "' . $categoryName . '" deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * BULK DELETE
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:product_categories,id'
            ]);

            // Check for children
            foreach ($request->ids as $id) {
                $category = ProductCategory::find($id);
                if ($category && $category->children()->count() > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete category "' . $category->name . '" because it has subcategories.'
                    ], 422);
                }
            }

            // Delete images
            $categories = ProductCategory::whereIn('id', $request->ids)->get();
            foreach ($categories as $category) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
            }

            ProductCategory::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categories deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete categories'
            ], 500);
        }
    }

    /**
     * TOGGLE STATUS
     */
    public function toggleStatus(ProductCategory $productCategory)
    {
        try {
            $productCategory->is_active = !$productCategory->is_active;
            $productCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated!',
                'is_active' => $productCategory->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    /**
     * UPDATE ORDER (Drag-drop)
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:product_categories,id',
                'items.*.sort_order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                ProductCategory::where('id', $item['id'])
                    ->update(['sort_order' => $item['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order'
            ], 500);
        }
    }
}