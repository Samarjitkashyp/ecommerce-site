<?php
// database/migrations/2026_02_24_999999_rename_categories_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pehle home_categories ka data categories mein merge karo
        if (Schema::hasTable('home_categories') && Schema::hasTable('categories')) {
            DB::statement('
                INSERT INTO categories (name, slug, image, sort_order, is_active, created_at, updated_at)
                SELECT 
                    COALESCE(hc.custom_name, c.name) as name,
                    c.slug as slug,
                    COALESCE(hc.custom_image, c.image) as image,
                    hc.sort_order,
                    hc.is_active,
                    NOW(),
                    NOW()
                FROM home_categories hc
                JOIN categories c ON c.id = hc.category_id
            ');
        }

        // Purani tables drop karo
        Schema::dropIfExists('home_categories');
        
        // Categories table ka naam change karo
        Schema::rename('categories', 'product_categories');
    }

    public function down(): void
    {
        Schema::rename('product_categories', 'categories');
    }
};