<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends AdminController
{
    /**
     * DISPLAY ALL CATEGORIES
     */
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * STORE NEW CATEGORY
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:categories',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:categories,id',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('categories', 'public');
                $validated['image'] = $path;
            }

            // Create category
            $category = Category::create($validated);

            Log::info('Category created', ['category_id' => $category->id, 'name' => $category->name]);

            return $this->sendSuccess(
                'Category created successfully!',
                ['category' => $category],
                route('admin.categories.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create category', [], 500);
        }
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * UPDATE CATEGORY
     */
    public function update(Request $request, Category $category)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:categories,id',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                
                $path = $request->file('image')->store('categories', 'public');
                $validated['image'] = $path;
            }

            // Update category
            $category->update($validated);

            Log::info('Category updated', ['category_id' => $category->id, 'name' => $category->name]);

            return $this->sendSuccess(
                'Category updated successfully!',
                ['category' => $category],
                route('admin.categories.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());
            return $this->sendError('Failed to update category', [], 500);
        }
    }

    /**
     * DELETE CATEGORY
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has children
            if ($category->children()->count() > 0) {
                return $this->sendError('Cannot delete category with subcategories. Delete subcategories first.');
            }

            // Delete image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $categoryName = $category->name;
            $category->delete();

            Log::info('Category deleted', ['category_name' => $categoryName]);

            return $this->sendSuccess('Category deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Category deletion error: ' . $e->getMessage());
            return $this->sendError('Failed to delete category', [], 500);
        }
    }

    /**
     * BULK DELETE CATEGORIES
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:categories,id'
            ]);

            Category::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categories deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk category delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete categories'
            ], 500);
        }
    }

    /**
     * UPDATE CATEGORY STATUS
     */
    public function updateStatus(Request $request, Category $category)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean'
            ]);

            $category->update(['is_active' => $request->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Category status updated!'
            ]);

        } catch (\Exception $e) {
            Log::error('Category status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    /**
     * GET CATEGORY TREE (AJAX)
     */
    public function getTree()
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}