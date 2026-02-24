<?php
// database/seeders/ProductCategorySeeder.php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fashion',
                'icon' => 'fas fa-tshirt',
                'description' => 'Latest fashion trends for men and women',
                'sort_order' => 1
            ],
            [
                'name' => 'Electronics',
                'icon' => 'fas fa-mobile-alt',
                'description' => 'Gadgets, mobiles, laptops and more',
                'sort_order' => 2
            ],
            [
                'name' => 'Home & Kitchen',
                'icon' => 'fas fa-home',
                'description' => 'Everything for your home',
                'sort_order' => 3
            ],
            [
                'name' => 'Books',
                'icon' => 'fas fa-book',
                'description' => 'Millions of books available',
                'sort_order' => 4
            ],
            [
                'name' => 'Sports',
                'icon' => 'fas fa-futbol',
                'description' => 'Sports equipment and accessories',
                'sort_order' => 5
            ],
            [
                'name' => 'Toys & Baby',
                'icon' => 'fas fa-baby',
                'description' => 'Toys and baby care products',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $cat) {
            ProductCategory::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => Str::slug($cat['name']),
                    'icon' => $cat['icon'],
                    'description' => $cat['description'],
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true
                ]
            );
        }

        $this->command->info('✅ Product categories seeded successfully!');
    }
}