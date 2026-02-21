<?php
// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_brand',
        'product_image',
        'price',
        'quantity',
        'selected_size',
        'selected_color',
        'total',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}