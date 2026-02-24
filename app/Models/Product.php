<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * THE TABLE NAME
     */
    protected $table = 'products';

    /**
     * MASS ASSIGNABLE FIELDS
     * Admin se jo bhi data aayega wo yahan fill hoga
     */
    protected $fillable = [
        'name',                 // Product name
        'slug',                 // SEO URL slug
        'brand',                // Brand name
        'sku',                  // Stock keeping unit
        'category_id',          // Category ID (ProductCategory se relation)
        'subcategory',          // Subcategory slug
        'price',                // Current price
        'original_price',       // Original price (for discount)
        'discount',             // Discount percentage
        'rating',               // Average rating
        'reviews_count',        // Total reviews
        'description',          // Detailed description
        'highlights',           // Key features (JSON array)
        'specifications',       // Technical specs (JSON array)
        'images',               // Multiple images (JSON array)
        'colors',               // Available colors (JSON array)
        'sizes',                // Available sizes (JSON array)
        'in_stock',             // Stock status (boolean)
        'stock_quantity',       // Actual stock count
        'badge',                // Badge text (NEW, TRENDING, BESTSELLER)
        'seller',               // Seller name
        'seller_rating',        // Seller rating
        'seller_ratings_count', // Seller ratings count
        'warranty',             // Warranty information
        'meta_title',           // SEO title
        'meta_description',     // SEO description
        'meta_keywords',        // SEO keywords
        'is_active',            // Product status
        'is_featured',          // Featured product
        'sort_order',           // Display order
    ];

    /**
     * CAST ATTRIBUTES TO PROPER TYPES
     * JSON fields ko automatically array mein convert karega
     */
    protected $casts = [
        'highlights' => 'array',        // Stored as JSON in DB
        'specifications' => 'array',    // Stored as JSON in DB
        'images' => 'array',             // Stored as JSON in DB
        'colors' => 'array',             // Stored as JSON in DB
        'sizes' => 'array',              // Stored as JSON in DB
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'float',
        'price' => 'float',
        'original_price' => 'float',
        'discount' => 'integer',
        'reviews_count' => 'integer',
        'stock_quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * RELATIONSHIP WITH CATEGORY
     * Har product ek category mein hota hai
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * RELATIONSHIP WITH ORDER ITEMS
     * Product kitne orders mein hai
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    /**
     * ACCESSOR: Get product URL
     * SEO friendly URL generate karta hai
     */
    public function getUrlAttribute()
    {
        return route('product.detail', [
            'id' => $this->id,
            'slug' => $this->slug ?? Str::slug($this->name)
        ]);
    }

    /**
     * ACCESSOR: Get main image
     * Pehli image return karta hai
     */
    public function getMainImageAttribute()
    {
        $images = $this->images;
        if (is_array($images) && count($images) > 0) {
            return $images['main'] ?? ($images[0] ?? null);
        }
        return 'https://picsum.photos/500/500?random=' . $this->id;
    }

    /**
     * ACCESSOR: Get thumbnail images
     * Sab images return karta hai thumbnails ke liye
     */
    public function getThumbnailImagesAttribute()
    {
        $images = $this->images;
        if (is_array($images)) {
            return $images['thumbnails'] ?? $images;
        }
        return [];
    }

    /**
     * ACCESSOR: Get discount percentage
     * Automatically calculate karta hai agar discount nahi diya
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount) {
            return $this->discount;
        }
        
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        
        return 0;
    }

    /**
     * SCOPE: Active products only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * SCOPE: Featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * SCOPE: In stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true)->where('stock_quantity', '>', 0);
    }

    /**
     * SCOPE: Search by name or brand
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('brand', 'LIKE', "%{$term}%")
              ->orWhere('sku', 'LIKE', "%{$term}%");
        });
    }

    /**
     * BOOT METHOD
     * Auto-generate slug when creating/updating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            // Auto-calculate discount if not set
            if (empty($product->discount) && $product->original_price > $product->price) {
                $product->discount = round((($product->original_price - $product->price) / $product->original_price) * 100);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            // Recalculate discount if prices changed
            if ($product->isDirty('price') || $product->isDirty('original_price')) {
                if ($product->original_price > $product->price) {
                    $product->discount = round((($product->original_price - $product->price) / $product->original_price) * 100);
                }
            }
        });
    }
}