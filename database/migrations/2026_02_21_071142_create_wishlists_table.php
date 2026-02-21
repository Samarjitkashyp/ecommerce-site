<?php
// database/migrations/2024_01_01_000004_create_wishlists_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('product_brand');
            $table->decimal('price', 10, 2);
            $table->string('product_image');
            $table->timestamps();
            
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};