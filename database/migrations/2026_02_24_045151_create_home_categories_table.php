<?php
// database/migrations/2026_02_24_045151_create_home_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_categories', function (Blueprint $table) {
            $table->id();
            
            // 🔗 RELATIONSHIP WITH MAIN CATEGORIES TABLE
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            
            // 🖼️ CUSTOM IMAGE (Optional)
            $table->string('custom_image')->nullable();
            
            // 🎯 CUSTOM NAME (Optional)
            $table->string('custom_name')->nullable();
            
            // 📍 DISPLAY ORDER (Drag-drop ke liye)
            $table->integer('sort_order')->default(0);
            
            // 👁️ VISIBILITY TOGGLE
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // 🎯 INDEXES for better performance
            $table->index('sort_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_categories');
    }
};