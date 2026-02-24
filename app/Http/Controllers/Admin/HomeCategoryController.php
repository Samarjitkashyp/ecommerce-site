<?php
// app/Http/Controllers/Admin/HomeCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeCategoryController extends AdminController
{
    /**
     * DISPLAY ALL HOME CATEGORIES
     */
    public function index()
    {
        $homeCategories = HomeCategory::with('category')
            ->orderBy('sort_order')
            ->get();

        return view('admin.home-categories.index', compact('homeCategories'));
    }

    /**
     * SHOW CREATE FORM - FIXED: Sabhi active categories dikhao
     */
    public function create()
    {
        // 🟢 FIXED: Sirf active categories dikhao, parent categories bhi dikhao
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Debug ke liye - check karo categories aa rahi hain ya nahi
        if ($categories->isEmpty()) {
            Log::warning('No categories found! Please create categories first.');
        }

        return view('admin.home-categories.create', compact('categories'));
    }

    /**
     * STORE NEW HOME CATEGORY - FIXED: Better validation
     */
    public function store(Request $request)
    {
        try {
            // 🟢 FIXED: Validation rules
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'custom_name' => 'nullable|string|max:255',
                'custom_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'is_active' => 'sometimes|boolean'
            ]);

            // 🟢 FIXED: Check if category already exists
            $exists = HomeCategory::where('category_id', $validated['category_id'])->first();
            if ($exists) {
                return $this->sendError('This category is already added to homepage!');
            }

            // Handle image upload
            if ($request->hasFile('custom_image')) {
                $path = $request->file('custom_image')->store('home-categories', 'public');
                $validated['custom_image'] = $path;
            }

            // Get max sort order
            $maxOrder = HomeCategory::max('sort_order') ?? 0;
            $validated['sort_order'] = $maxOrder + 1;
            
            // Set is_active
            $validated['is_active'] = $request->has('is_active');

            // Create
            $homeCategory = HomeCategory::create($validated);

            return $this->sendSuccess(
                'Category added to homepage successfully!',
                ['home_category' => $homeCategory],
                route('admin.home-categories.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Home category creation error: ' . $e->getMessage());
            return $this->sendError('Failed to add category: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit(HomeCategory $homeCategory)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.home-categories.edit', compact('homeCategory', 'categories'));
    }

    /**
     * UPDATE HOME CATEGORY
     */
    public function update(Request $request, HomeCategory $homeCategory)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'custom_name' => 'nullable|string|max:255',
                'custom_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'is_active' => 'sometimes|boolean'
            ]);

            // Check duplicate
            $exists = HomeCategory::where('category_id', $validated['category_id'])
                ->where('id', '!=', $homeCategory->id)
                ->exists();
            
            if ($exists) {
                return $this->sendError('This category is already added to homepage by another record!');
            }

            // Handle image upload
            if ($request->hasFile('custom_image')) {
                if ($homeCategory->custom_image) {
                    Storage::disk('public')->delete($homeCategory->custom_image);
                }
                $path = $request->file('custom_image')->store('home-categories', 'public');
                $validated['custom_image'] = $path;
            }

            // Handle image removal
            if ($request->has('remove_image')) {
                if ($homeCategory->custom_image) {
                    Storage::disk('public')->delete($homeCategory->custom_image);
                }
                $validated['custom_image'] = null;
            }

            $validated['is_active'] = $request->has('is_active');

            $homeCategory->update($validated);

            return $this->sendSuccess(
                'Home category updated successfully!',
                ['home_category' => $homeCategory],
                route('admin.home-categories.index')
            );

        } catch (\Exception $e) {
            Log::error('Home category update error: ' . $e->getMessage());
            return $this->sendError('Failed to update category: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * DELETE FROM HOMEPAGE
     */
    public function destroy(HomeCategory $homeCategory)
    {
        try {
            if ($homeCategory->custom_image) {
                Storage::disk('public')->delete($homeCategory->custom_image);
            }

            $homeCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category removed from homepage!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * UPDATE DISPLAY ORDER
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:home_categories,id',
                'items.*.sort_order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                HomeCategory::where('id', $item['id'])
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

    /**
     * TOGGLE VISIBILITY
     */
    public function toggleStatus(HomeCategory $homeCategory)
    {
        try {
            $homeCategory->is_active = !$homeCategory->is_active;
            $homeCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated!',
                'is_active' => $homeCategory->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
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
                'ids.*' => 'exists:home_categories,id'
            ]);

            $homeCategories = HomeCategory::whereIn('id', $request->ids)->get();
            foreach ($homeCategories as $item) {
                if ($item->custom_image) {
                    Storage::disk('public')->delete($item->custom_image);
                }
            }

            HomeCategory::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categories removed from homepage!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete categories'
            ], 500);
        }
    }
}