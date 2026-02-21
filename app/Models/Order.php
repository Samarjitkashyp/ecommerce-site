<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'address_id',
        'subtotal',
        'discount',
        'delivery_charge',
        'tax',
        'total',
        'coupon_code',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
        'delivered_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge bg-warning text-dark',
            'confirmed' => 'badge bg-info',
            'processing' => 'badge bg-primary',
            'shipped' => 'badge bg-secondary',
            'out_for_delivery' => 'badge bg-dark',
            'delivered' => 'badge bg-success',
            'cancelled' => 'badge bg-danger',
            'returned' => 'badge bg-danger',
        ];
        
        return $badges[$this->order_status] ?? 'badge bg-secondary';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
        ];
        
        return $texts[$this->order_status] ?? ucfirst($this->order_status);
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge bg-warning text-dark',
            'completed' => 'badge bg-success',
            'failed' => 'badge bg-danger',
            'refunded' => 'badge bg-info',
        ];
        
        return $badges[$this->payment_status] ?? 'badge bg-secondary';
    }
}