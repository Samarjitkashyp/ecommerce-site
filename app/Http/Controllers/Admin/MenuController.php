<?php
// app/Http/Controllers/Admin/MenuController.php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
     * FIXED: URL validation now accepts # for placeholder links
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:link,category,dropdown,route',
                // FIXED: URL can be # for placeholder links
                'url' => [
                    'required_if:type,link',
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($value !== null && $value !== '#' && !filter_var($value, FILTER_VALIDATE_URL)) {
                            $fail('The URL must be a valid URL or # for placeholder.');
                        }
                    },
                ],
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
                // FIXED: Allow # as valid URL
                'url' => $validated['url'] ?? '#',
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
     * FIXED: URL validation now accepts # for placeholder links
     */
    public function update(Request $request, Menu $menu)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:link,category,dropdown,route',
                // FIXED: URL can be # for placeholder links
                'url' => [
                    'required_if:type,link',
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($value !== null && $value !== '#' && !filter_var($value, FILTER_VALIDATE_URL)) {
                            $fail('The URL must be a valid URL or # for placeholder.');
                        }
                    },
                ],
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
                // FIXED: Allow # as valid URL
                'url' => $validated['url'] ?? '#',
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
     * DELETE MENU WITH CHILDREN
     */
    public function destroy(Menu $menu)
    {
        try {
            $menuId = $menu->id;
            $menuName = $menu->name;
            
            // Count children before deleting
            $childrenCount = $menu->children()->count();
            
            // First delete all child menus
            if ($childrenCount > 0) {
                foreach ($menu->children as $child) {
                    $child->delete();
                }
            }
            
            // Then delete parent menu
            $menu->delete();

            Log::info('Menu deleted with children', [
                'menu_id' => $menuId, 
                'menu_name' => $menuName,
                'children_deleted' => $childrenCount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu and ' . $childrenCount . ' child item(s) deleted successfully!',
                'id' => $menuId
            ]);

        } catch (\Exception $e) {
            Log::error('Menu deletion error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete menu: ' . $e->getMessage()
            ], 500);
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

    /**
     * SHOW MENU LOCATIONS PAGE
     */
    public function locations()
    {
        $locations = Menu::LOCATIONS;
        $menusByLocation = [];
        
        foreach (array_keys($locations) as $location) {
            $menusByLocation[$location] = Menu::with('children')
                ->where('location', $location)
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->get();
        }
        
        return view('admin.menus.locations', compact('locations', 'menusByLocation'));
    }
}