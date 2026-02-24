<?php
// app/Models/HomeCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeCategory extends Model
{
    use HasFactory;

    /**
     * 🟢 MASS ASSIGNABLE FIELDS
     */
    protected $fillable = [
        'category_id',
        'custom_image',
        'custom_name',
        'sort_order',
        'is_active'
    ];

    /**
     * 🔄 CASTING
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * 🔗 RELATIONSHIP: Belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 🖼️ ACCESSOR: Get display image
     */
    public function getDisplayImageAttribute()
    {
        if ($this->custom_image) {
            return asset('storage/' . $this->custom_image);
        }
        
        if ($this->category && $this->category->image) {
            return asset('storage/' . $this->category->image);
        }
        
        // Default fallback images based on category
        $fallbacks = [
            'Fashion' => 'https://picsum.photos/200/200?random=1',
            'Electronics' => 'https://picsum.photos/200/200?random=2',
            'Home & Kitchen' => 'https://picsum.photos/200/200?random=3',
            'Books' => 'https://picsum.photos/200/200?random=4',
            'Sports' => 'https://picsum.photos/200/200?random=5',
            'Toys & Baby' => 'https://picsum.photos/200/200?random=6',
        ];
        
        $categoryName = $this->category->name ?? 'Category';
        return $fallbacks[$categoryName] ?? 'https://picsum.photos/200/200?random=' . $this->id;
    }

    /**
     * 📛 ACCESSOR: Get display name
     */
    public function getDisplayNameAttribute()
    {
        return $this->custom_name ?? ($this->category->name ?? 'Category');
    }

    /**
     * 🔗 ACCESSOR: Get category URL
     */
    public function getUrlAttribute()
    {
        if ($this->category && $this->category->slug) {
            return route('category', $this->category->slug);
        }
        return '#';
    }

    /**
     * 🟢 SCOPE: Active only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('sort_order');
    }

    /**
     * 🟢 SCOPE: With category eager loaded
     */
    public function scopeWithCategory($query)
    {
        return $query->with('category');
    }
}