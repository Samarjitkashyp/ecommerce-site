<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 🟢 GET ACTIVE PRODUCT CATEGORIES FOR HOMEPAGE
        $productCategories = ProductCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProducts = $this->getFeaturedProducts();

        return view('front.index', compact('productCategories', 'featuredProducts'));
    }

    /**
     * Sample featured products
     */
    private function getFeaturedProducts()
    {
        return [
            [
                'id' => 1,
                'brand' => 'Jack & Jones',
                'name' => 'Men\'s Printed Round Neck Pure Cotton T-Shirt',
                'price' => 799,
                'original_price' => 2499,
                'discount' => 68,
                'rating' => 4.3,
                'reviews' => 3245,
                'image' => 'https://picsum.photos/300/300?random=201',
                'badge' => 'BESTSELLER',
                'slug' => 'mens-printed-cotton-tshirt'
            ],
            [
                'id' => 2,
                'brand' => 'Puma',
                'name' => 'Men\'s Running Shoes | Lightweight',
                'price' => 2499,
                'original_price' => 3999,
                'discount' => 37,
                'rating' => 4.5,
                'reviews' => 5123,
                'image' => 'https://picsum.photos/300/300?random=202',
                'badge' => 'TRENDING',
                'slug' => 'mens-running-shoes'
            ],
            [
                'id' => 3,
                'brand' => 'Nike',
                'name' => 'Men\'s Solid Regular Fit T-Shirt',
                'price' => 1799,
                'original_price' => 2499,
                'discount' => 28,
                'rating' => 4.2,
                'reviews' => 1845,
                'image' => 'https://picsum.photos/300/300?random=203',
                'badge' => 'NEW',
                'slug' => 'mens-solid-tshirt'
            ],
            [
                'id' => 4,
                'brand' => 'Levi\'s',
                'name' => 'Men\'s Skinny Fit Jeans',
                'price' => 2299,
                'original_price' => 3299,
                'discount' => 30,
                'rating' => 4.4,
                'reviews' => 2345,
                'image' => 'https://picsum.photos/300/300?random=204',
                'badge' => 'BESTSELLER',
                'slug' => 'mens-skinny-jeans'
            ],
        ];
    }
}