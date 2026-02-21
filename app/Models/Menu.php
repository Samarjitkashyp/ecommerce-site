<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * THE ATTRIBUTES THAT ARE MASS ASSIGNABLE
     */
    protected $fillable = [
        'name',
        'type',
        'url',
        'route',
        'parent_id',
        'category_id',
        'icon',
        'target',
        'sort_order',
        'location',
        'is_active',
        'permission',
        'is_visible'
    ];

    /**
     * THE ATTRIBUTES THAT SHOULD BE CAST
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * AVAILABLE MENU TYPES
     */
    const TYPES = [
        'link' => 'Custom Link',
        'category' => 'Category Link',
        'dropdown' => 'Dropdown Parent',
        'route' => 'Route Name'
    ];

    /**
     * AVAILABLE MENU LOCATIONS
     */
    const LOCATIONS = [
        'main' => 'Main Navigation',
        'top' => 'Top Bar',
        'footer' => 'Footer',
        'sidebar' => 'Sidebar'
    ];

    /**
     * RELATIONSHIP: PARENT MENU
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * RELATIONSHIP: CHILD MENUS
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * RELATIONSHIP: CATEGORY
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * SCOPE: ACTIVE MENUS
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * SCOPE: VISIBLE MENUS
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * SCOPE: BY LOCATION
     */
    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * SCOPE: PARENT MENUS ONLY
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * GET THE MENU URL
     */
    public function getUrlAttribute()
    {
        if ($this->type === 'category' && $this->category) {
            return $this->category->url;
        }

        if ($this->type === 'route' && $this->route) {
            return route($this->route);
        }

        return $this->url ?? '#';
    }

    /**
     * CHECK IF MENU HAS CHILDREN
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * GET ALL CHILDREN RECURSIVELY
     */
    public function getAllChildren()
    {
        $children = collect();

        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->getAllChildren());
        }

        return $children;
    }

    /**
     * BOOT THE MODEL
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set type for category
        static::saving(function ($menu) {
            if ($menu->category_id && !$menu->type) {
                $menu->type = 'category';
            }
        });
    }
}