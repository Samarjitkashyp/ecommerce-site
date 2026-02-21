<?php
// database/migrations/2026_02_21_000002_create_menus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN THE MIGRATIONS
     * Dynamic menu management
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            
            // Menu Item Information
            $table->string('name');                              // Display name (e.g., MX Player)
            $table->string('type')->default('link');             // Type: link, dropdown, category, custom
            $table->string('url')->nullable();                   // URL for link type
            $table->string('route')->nullable();                 // Laravel route name
            
            // Parent-Child Relationship
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('menus')
                  ->onDelete('cascade');
            
            // Category Relationship (if type = category)
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            
            // Display Settings
            $table->string('icon')->nullable();                   // Icon class
            $table->string('target')->default('_self');          // _self, _blank
            $table->integer('sort_order')->default(0);           // Display order
            $table->string('location')->default('main');         // main, top, footer, sidebar
            $table->boolean('is_active')->default(true);         // Active/Inactive
            
            // Permissions
            $table->string('permission')->nullable();            // Required permission
            $table->boolean('is_visible')->default(true);        // Visible to guests
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * REVERSE THE MIGRATIONS
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};