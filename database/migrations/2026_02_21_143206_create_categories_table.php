<?php
// database/migrations/2026_02_21_000001_create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN THE MIGRATIONS
     * Categories for products and menu items
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');                              // Category name (e.g., Fashion)
            $table->string('slug')->unique();                    // URL slug (e.g., fashion)
            $table->text('description')->nullable();              // Category description
            
            // Parent-Child Relationship (for subcategories)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('cascade');
            
            // Display Settings
            $table->string('icon')->nullable();                   // Font Awesome icon class
            $table->string('image')->nullable();                  // Category image
            $table->integer('sort_order')->default(0);           // Display order
            $table->boolean('is_active')->default(true);         // Active/Inactive
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            $table->timestamps();
            $table->softDeletes();                                // For trash feature
        });
    }

    /**
     * REVERSE THE MIGRATIONS
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};