<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category page
     *
     * @param string $category
     * @return \Illuminate\View\View
     */
    public function show($category)
    {
        // Category data mapping
        $categories = [
            'fashion' => [
                'name' => 'Fashion',
                'title' => 'Men\'s Fashion',
                'products_count' => 12456,
                'description' => 'Explore the latest trends in fashion',
                'breadcrumb' => 'Home / Products / Fashion'
            ],
            'electronics' => [
                'name' => 'Electronics',
                'title' => 'Electronics',
                'products_count' => 8932,
                'description' => 'Latest gadgets and electronics',
                'breadcrumb' => 'Home / Products / Electronics'
            ],
            'home-kitchen' => [
                'name' => 'Home & Kitchen',
                'title' => 'Home & Kitchen',
                'products_count' => 5678,
                'description' => 'Everything for your home',
                'breadcrumb' => 'Home / Products / Home & Kitchen'
            ],
            'books' => [
                'name' => 'Books',
                'title' => 'Books',
                'products_count' => 4321,
                'description' => 'Millions of books available',
                'breadcrumb' => 'Home / Products / Books'
            ],
            'sports' => [
                'name' => 'Sports',
                'title' => 'Sports & Fitness',
                'products_count' => 3210,
                'description' => 'Sports equipment and accessories',
                'breadcrumb' => 'Home / Products / Sports'
            ],
            'toys-baby' => [
                'name' => 'Toys & Baby',
                'title' => 'Toys & Baby Products',
                'products_count' => 2456,
                'description' => 'Toys and baby care products',
                'breadcrumb' => 'Home / Products / Toys & Baby'
            ],
            'auto-accessories' => [
                'name' => 'Auto Accessories',
                'title' => 'Auto Accessories',
                'products_count' => 1890,
                'description' => 'Car and bike accessories',
                'breadcrumb' => 'Home / Products / Auto Accessories'
            ],
            'travel' => [
                'name' => 'Travel',
                'title' => 'Travel & Luggage',
                'products_count' => 1234,
                'description' => 'Travel bags and accessories',
                'breadcrumb' => 'Home / Products / Travel'
            ],
            'genz-trends' => [
                'name' => 'GenZ Trends',
                'title' => 'GenZ Trends',
                'products_count' => 987,
                'description' => 'Trendy products for GenZ',
                'breadcrumb' => 'Home / Products / GenZ Trends'
            ],
            'next-gen' => [
                'name' => 'Next Gen',
                'title' => 'Next Generation Products',
                'products_count' => 756,
                'description' => 'Future tech and innovation',
                'breadcrumb' => 'Home / Products / Next Gen'
            ],
        ];
        
        // Check if category exists
        if (!array_key_exists($category, $categories)) {
            abort(404, 'Category not found');
        }
        
        $categoryInfo = $categories[$category];
        
        // Sample products for this category
        $products = $this->getProductsByCategory($category);
        
        return view('front.category', compact('category', 'categoryInfo', 'products'));
    }
    
    /**
     * Get products by category (sample data)
     *
     * @param string $category
     * @return array
     */
    private function getProductsByCategory($category)
    {
        // Sample products data - in real project, yeh database se aayega
        $allProducts = [
            'fashion' => [
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
                    'badge' => 'BESTSELLER'
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
                    'badge' => 'TRENDING'
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
                    'badge' => 'NEW'
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
                    'badge' => 'BESTSELLER'
                ],
                [
                    'id' => 5,
                    'brand' => 'Adidas',
                    'name' => 'Men\'s Sports Shoes',
                    'price' => 2999,
                    'original_price' => 4999,
                    'discount' => 40,
                    'rating' => 4.6,
                    'reviews' => 4231,
                    'image' => 'https://picsum.photos/300/300?random=205',
                    'badge' => 'TRENDING'
                ],
                [
                    'id' => 6,
                    'brand' => 'Fastrack',
                    'name' => 'Men\'s Analog Watch',
                    'price' => 1995,
                    'original_price' => 2995,
                    'discount' => 33,
                    'rating' => 4.7,
                    'reviews' => 6789,
                    'image' => 'https://picsum.photos/300/300?random=206',
                    'badge' => 'NEW'
                ],
                [
                    'id' => 7,
                    'brand' => 'Roadster',
                    'name' => 'Men\'s Cotton Jacket',
                    'price' => 1999,
                    'original_price' => 3999,
                    'discount' => 50,
                    'rating' => 4.3,
                    'reviews' => 1890,
                    'image' => 'https://picsum.photos/300/300?random=207',
                    'badge' => 'BESTSELLER'
                ],
                [
                    'id' => 8,
                    'brand' => 'HRX',
                    'name' => 'Men\'s Gym T-Shirt',
                    'price' => 699,
                    'original_price' => 1299,
                    'discount' => 46,
                    'rating' => 4.1,
                    'reviews' => 2341,
                    'image' => 'https://picsum.photos/300/300?random=208',
                    'badge' => 'TRENDING'
                ],
            ],
            'electronics' => [
                [
                    'id' => 101,
                    'brand' => 'Sony',
                    'name' => 'Wireless Bluetooth Headphones',
                    'price' => 3999,
                    'original_price' => 5999,
                    'discount' => 33,
                    'rating' => 4.6,
                    'reviews' => 4231,
                    'image' => 'https://picsum.photos/300/300?random=301',
                    'badge' => 'BESTSELLER'
                ],
                [
                    'id' => 102,
                    'brand' => 'Boat',
                    'name' => 'Smart Watch',
                    'price' => 2499,
                    'original_price' => 4999,
                    'discount' => 50,
                    'rating' => 4.3,
                    'reviews' => 5678,
                    'image' => 'https://picsum.photos/300/300?random=302',
                    'badge' => 'TRENDING'
                ],
            ],
            'travel' => [
                [
                    'id' => 201,
                    'brand' => 'American Tourister',
                    'name' => 'Hard-Sided Luggage Bag',
                    'price' => 3999,
                    'original_price' => 7999,
                    'discount' => 50,
                    'rating' => 4.4,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=401',
                    'badge' => 'BESTSELLER'
                ],
            ],
        ];
        
        return $allProducts[$category] ?? [];
    }
}