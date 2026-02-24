<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fashion',
            'Electronics',
            'Home & Kitchen',
            'Books',
            'Sports',
            'Toys & Baby',
            'Auto Accessories',
            'Travel',
            'GenZ Trends',
            'Next Gen'
        ];

        foreach ($categories as $index => $name) {
            Category::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'is_active' => true,
                    'sort_order' => $index + 1,
                    'description' => 'Shop the best ' . $name . ' products'
                ]
            );
        }

        $this->command->info('✅ Categories created successfully!');
    }
}