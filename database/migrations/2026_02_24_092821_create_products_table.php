<?php
// database/migrations/2026_02_24_000001_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN THE MIGRATIONS
     * Yeh table create karega products ke liye
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('sku')->unique()->nullable();
            
            // Category Relationship
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('product_categories')
                  ->onDelete('set null');
            $table->string('subcategory')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->integer('discount')->default(0);
            
            // Ratings
            $table->float('rating')->default(0);
            $table->integer('reviews_count')->default(0);
            
            // Content
            $table->text('description')->nullable();
            $table->json('highlights')->nullable();       // JSON array
            $table->json('specifications')->nullable();   // JSON array
            
            // Media
            $table->json('images')->nullable();           // JSON array {main, thumbnails[]}
            $table->json('colors')->nullable();           // JSON array
            $table->json('sizes')->nullable();            // JSON array
            
            // Stock
            $table->boolean('in_stock')->default(true);
            $table->integer('stock_quantity')->default(0);
            $table->string('badge')->nullable();          // NEW, TRENDING, BESTSELLER
            
            // Seller Info
            $table->string('seller')->nullable();
            $table->float('seller_rating')->nullable();
            $table->integer('seller_ratings_count')->nullable();
            $table->text('warranty')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes(); // For soft delete
        });
    }

    /**
     * REVERSE THE MIGRATIONS
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};