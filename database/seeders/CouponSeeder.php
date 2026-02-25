<?php
// database/seeders/CouponSeeder.php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'SAVE10',
                'name' => '10% Off',
                'description' => 'Get 10% discount on your order',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 0,
                'max_discount_amount' => null,
                'usage_limit' => 1000,
                'usage_per_user' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'SAVE20',
                'name' => '20% Off',
                'description' => 'Get 20% discount on orders above ₹1000',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 1000,
                'max_discount_amount' => 500,
                'usage_limit' => 500,
                'usage_per_user' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT500',
                'name' => 'Flat ₹500 Off',
                'description' => 'Get ₹500 off on orders above ₹2500',
                'type' => 'fixed',
                'value' => 500,
                'min_order_amount' => 2500,
                'max_discount_amount' => 500,
                'usage_limit' => 200,
                'usage_per_user' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'WELCOME50',
                'name' => 'Welcome ₹50 Off',
                'description' => 'Special discount for new customers',
                'type' => 'fixed',
                'value' => 50,
                'min_order_amount' => 0,
                'max_discount_amount' => 50,
                'usage_limit' => 500,
                'usage_per_user' => 1,
                'is_active' => true,
            ],
            [
                'code' => 'FREEDEL',
                'name' => 'Free Delivery',
                'description' => 'Free delivery on your order',
                'type' => 'fixed',
                'value' => 40,
                'min_order_amount' => 0,
                'max_discount_amount' => 40,
                'usage_limit' => null,
                'usage_per_user' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }

        $this->command->info('✅ Coupons seeded successfully!');
    }
}