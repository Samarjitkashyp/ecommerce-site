<?php
// database/migrations/2024_01_01_000003_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('product_brand');
            $table->string('product_image');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('selected_size')->nullable();
            $table->string('selected_color')->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};