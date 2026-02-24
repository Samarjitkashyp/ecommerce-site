<?php
// database/migrations/2026_02_22_143258_create_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('link');
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('menus')
                  ->onDelete('cascade');
            
            // 🔥 YE TABLE AB EXIST KAREGI
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('product_categories')
                  ->onDelete('set null');
            
            $table->string('icon')->nullable();
            $table->string('target')->default('_self');
            $table->integer('sort_order')->default(0);
            $table->string('location')->default('main');
            $table->boolean('is_active')->default(true);
            $table->string('permission')->nullable();
            $table->boolean('is_visible')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};