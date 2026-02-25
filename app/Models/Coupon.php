<?php
// app/Models/Coupon.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_per_user',
        'total_used',
        'starts_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'value' => 'float',
        'min_order_amount' => 'float',
        'max_discount_amount' => 'float'
    ];

    /**
     * Get active coupons for display on cart and product pages
     */
    public static function getActiveCoupons()
    {
        return self::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('starts_at')
                      ->orWhere('starts_at', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->where(function($query) {
                $query->whereNull('usage_limit')
                      ->orWhereColumn('total_used', '<', 'usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get formatted offer text for display
     */
    public function getOfferTextAttribute()
    {
        if ($this->type == 'percentage') {
            $text = $this->value . '% off';
        } else {
            $text = '₹' . number_format($this->value) . ' off';
        }
        
        if ($this->min_order_amount) {
            $text .= ' on orders above ₹' . number_format($this->min_order_amount);
        }
        
        return $text;
    }

    /**
     * Check if coupon is valid for a user
     */
    public function isValidForUser($userId, $subtotal = null)
    {
        // Check basic validity
        if (!$this->isValid($subtotal)) {
            return false;
        }
        
        // Check usage per user
        if ($this->usage_per_user && $userId) {
            $userUsage = \App\Models\Order::where('user_id', $userId)
                ->where('coupon_code', $this->code)
                ->count();
                
            if ($userUsage >= $this->usage_per_user) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Check if coupon is valid
     */
    public function isValid($subtotal = null)
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }
        
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        
        if ($this->usage_limit && $this->total_used >= $this->usage_limit) {
            return false;
        }
        
        if ($subtotal && $this->min_order_amount && $subtotal < $this->min_order_amount) {
            return false;
        }
        
        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($subtotal)
    {
        if ($this->type == 'percentage') {
            $discount = ($subtotal * $this->value / 100);
            
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
        } else {
            $discount = $this->value;
        }
        
        return min($discount, $subtotal);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('total_used');
    }
}