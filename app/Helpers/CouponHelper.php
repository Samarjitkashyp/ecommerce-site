<?php
// app/Helpers/CouponHelper.php

namespace App\Helpers;

use App\Models\Coupon;
use Illuminate\Support\Facades\Schema;

class CouponHelper
{
    /**
     * Get active coupons for display
     */
    public static function getActiveCoupons()
    {
        if (Schema::hasTable('coupons')) {
            return Coupon::getActiveCoupons();
        }
        
        // Fallback hardcoded coupons
        return collect([
            (object)[
                'code' => 'SAVE10',
                'offer_text' => '10% off on your order',
                'description' => '10% instant discount',
                'type' => 'percentage',
                'value' => 10
            ],
            (object)[
                'code' => 'SAVE20',
                'offer_text' => '20% off on orders above ₹1000',
                'description' => '20% off on orders above ₹1000',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 1000
            ],
            (object)[
                'code' => 'FLAT500',
                'offer_text' => '₹500 off on orders above ₹2500',
                'description' => 'Flat ₹500 off',
                'type' => 'fixed',
                'value' => 500,
                'min_order_amount' => 2500
            ],
            (object)[
                'code' => 'WELCOME50',
                'offer_text' => '₹50 off for new customers',
                'description' => 'Welcome offer ₹50 off',
                'type' => 'fixed',
                'value' => 50
            ],
            (object)[
                'code' => 'FREEDEL',
                'offer_text' => 'Free delivery on your order',
                'description' => 'Free delivery',
                'type' => 'fixed',
                'value' => 40
            ],
        ]);
    }
    
    /**
     * Format coupon for display
     */
    public static function formatCouponText($coupon)
    {
        if (is_object($coupon) && property_exists($coupon, 'offer_text')) {
            return $coupon->offer_text;
        }
        
        if ($coupon->type == 'percentage') {
            $text = $coupon->value . '% off';
        } else {
            $text = '₹' . number_format($coupon->value) . ' off';
        }
        
        if (isset($coupon->min_order_amount) && $coupon->min_order_amount) {
            $text .= ' on orders above ₹' . number_format($coupon->min_order_amount);
        }
        
        return $text;
    }
}