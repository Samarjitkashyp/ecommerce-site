<?php
// app/Http/Controllers/Admin/MenuController.php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends AdminController
{
    /**
     * CONSTRUCTOR
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * DISPLAY ALL MENUS
     */
    public function index()
    {
        $menus = Menu::with('parent')
            ->orderBy('sort_order')
            ->orderBy('location')
            ->get();

        // Group menus by location
        $groupedMenus = $menus->groupBy('location');

        return view('admin.menus.index', compact('groupedMenus', 'menus'));
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->get();
        $categories = Category::active()->get();
        $types = Menu::TYPES;
        $locations = Menu::LOCATIONS;

        return view('admin.menus.create', compact('parentMenus', 'categories', 'types', 'locations'));
    }

    /**
     * STORE NEW MENU
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:link,category,dropdown,route',
                'url' => 'required_if:type,link|nullable|string',
                'route' => 'required_if:type,route|nullable|string',
                'category_id' => 'required_if:type,category|nullable|exists:categories,id',
                'parent_id' => 'nullable|exists:menus,id',
                'location' => 'required|in:main,top,footer,sidebar',
                'icon' => 'nullable|string|max:50',
                'target' => 'required|in:_self,_blank',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
                'is_visible' => 'boolean'
            ]);

            // Create menu
            $menu = Menu::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'url' => $validated['url'] ?? null,
                'route' => $validated['route'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'location' => $validated['location'],
                'icon' => $validated['icon'] ?? null,
                'target' => $validated['target'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $request->boolean('is_active', true),
                'is_visible' => $request->boolean('is_visible', true)
            ]);

            Log::info('Menu created', ['menu_id' => $menu->id, 'name' => $menu->name]);

            return $this->sendSuccess(
                'Menu created successfully!',
                ['menu' => $menu],
                route('admin.menus.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Menu creation error: ' . $e->getMessage());
            return $this->sendError('Failed to create menu', [], 500);
        }
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->get();
        
        $categories = Category::active()->get();
        $types = Menu::TYPES;
        $locations = Menu::LOCATIONS;

        return view('admin.menus.edit', compact('menu', 'parentMenus', 'categories', 'types', 'locations'));
    }

    /**
     * UPDATE MENU
     */
    public function update(Request $request, Menu $menu)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:link,category,dropdown,route',
                'url' => 'required_if:type,link|nullable|string',
                'route' => 'required_if:type,route|nullable|string',
                'category_id' => 'required_if:type,category|nullable|exists:categories,id',
                'parent_id' => 'nullable|exists:menus,id',
                'location' => 'required|in:main,top,footer,sidebar',
                'icon' => 'nullable|string|max:50',
                'target' => 'required|in:_self,_blank',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
                'is_visible' => 'boolean'
            ]);

            // Update menu
            $menu->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'url' => $validated['url'] ?? null,
                'route' => $validated['route'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'location' => $validated['location'],
                'icon' => $validated['icon'] ?? null,
                'target' => $validated['target'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $request->boolean('is_active', true),
                'is_visible' => $request->boolean('is_visible', true)
            ]);

            Log::info('Menu updated', ['menu_id' => $menu->id, 'name' => $menu->name]);

            return $this->sendSuccess(
                'Menu updated successfully!',
                ['menu' => $menu],
                route('admin.menus.index')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validation failed', $e->errors());
        } catch (\Exception $e) {
            Log::error('Menu update error: ' . $e->getMessage());
            return $this->sendError('Failed to update menu', [], 500);
        }
    }

    /**
     * DELETE MENU
     */
    public function destroy(Menu $menu)
    {
        try {
            // Check if menu has children
            if ($menu->children()->count() > 0) {
                return $this->sendError('Cannot delete menu with child items. Delete children first.');
            }

            $menuName = $menu->name;
            $menu->delete();

            Log::info('Menu deleted', ['menu_name' => $menuName]);

            return $this->sendSuccess('Menu deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Menu deletion error: ' . $e->getMessage());
            return $this->sendError('Failed to delete menu', [], 500);
        }
    }

    /**
     * UPDATE MENU ORDER
     */
    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:menus,id',
                'items.*.sort_order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Menu::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Menu order updated!'
            ]);

        } catch (\Exception $e) {
            Log::error('Menu order update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu order'
            ], 500);
        }
    }

    /**
     * GET MENUS FOR LOCATION (AJAX)
     */
    public function getMenusForLocation($location)
    {
        $menus = Menu::with('children')
            ->where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    /**
     * DUPLICATE MENU
     */
    public function duplicate(Menu $menu)
    {
        try {
            $newMenu = $menu->replicate();
            $newMenu->name = $menu->name . ' (Copy)';
            $newMenu->save();

            return $this->sendSuccess(
                'Menu duplicated successfully!',
                ['menu' => $newMenu],
                route('admin.menus.edit', $newMenu->id)
            );

        } catch (\Exception $e) {
            Log::error('Menu duplicate error: ' . $e->getMessage());
            return $this->sendError('Failed to duplicate menu', [], 500);
        }
    }
}