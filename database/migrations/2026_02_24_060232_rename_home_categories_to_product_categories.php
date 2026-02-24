<?php
// database/migrations/2026_02_24_000002_rename_home_categories_to_product_categories.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table rename
        Schema::rename('home_categories', 'product_categories');
    }

    public function down(): void
    {
        Schema::rename('product_categories', 'home_categories');
    }
};