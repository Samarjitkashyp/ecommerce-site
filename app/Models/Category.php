<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * THE ATTRIBUTES THAT ARE MASS ASSIGNABLE
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'icon',
        'image',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    /**
     * THE ATTRIBUTES THAT SHOULD BE CAST
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * BOOT THE MODEL
     * Auto-generate slug if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });
    }

    /**
     * RELATIONSHIP: PARENT CATEGORY
     * A category can belong to a parent category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * RELATIONSHIP: CHILD CATEGORIES
     * A category can have multiple subcategories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * RELATIONSHIP: MENUS
     * A category can be linked to multiple menu items
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * SCOPE: ACTIVE CATEGORIES
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * SCOPE: PARENT CATEGORIES ONLY
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
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
     * GET THE FULL CATEGORY PATH
     */
    public function getPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    /**
     * GET THE CATEGORY URL
     */
    public function getUrlAttribute()
    {
        return route('category', $this->slug);
    }
}