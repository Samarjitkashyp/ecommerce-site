<?php
// app/Models/ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'product_categories';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',              // Category name
        'slug',              // URL slug
        'description',       // Category description
        'parent_id',         // Parent category (for subcategories)
        'icon',              // Icon class
        'image',             // Category image
        'sort_order',        // Display order
        'is_active',         // Status
        'meta_title',        // SEO title
        'meta_description',  // SEO description
        'meta_keywords'      // SEO keywords
    ];

    /**
     * Casting
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Boot method - auto generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Parent category relationship
     */
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Child categories relationship
     */
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get category URL
     */
    public function getUrlAttribute()
    {
        return route('category', $this->slug);
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://picsum.photos/200/200?random=' . $this->id;
    }

    /**
     * Get full path (e.g., Electronics > Mobile Phones)
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
     * Scope active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope parent categories only
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}