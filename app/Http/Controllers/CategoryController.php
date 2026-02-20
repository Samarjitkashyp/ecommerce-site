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
        // Sample products data with slugs for SEO URLs
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
                    'badge' => 'TRENDING',
                    'slug' => 'mens-sports-shoes'
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
                    'badge' => 'NEW',
                    'slug' => 'mens-analog-watch'
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
                    'badge' => 'BESTSELLER',
                    'slug' => 'mens-cotton-jacket'
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
                    'badge' => 'TRENDING',
                    'slug' => 'mens-gym-tshirt'
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
                    'badge' => 'BESTSELLER',
                    'slug' => 'wireless-headphones'
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
                    'badge' => 'TRENDING',
                    'slug' => 'smart-watch'
                ],
                [
                    'id' => 103,
                    'brand' => 'Samsung',
                    'name' => 'Wireless Earbuds',
                    'price' => 5999,
                    'original_price' => 9999,
                    'discount' => 40,
                    'rating' => 4.5,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=303',
                    'badge' => 'NEW',
                    'slug' => 'wireless-earbuds'
                ],
                [
                    'id' => 104,
                    'brand' => 'OnePlus',
                    'name' => 'Smartphone',
                    'price' => 29999,
                    'original_price' => 34999,
                    'discount' => 14,
                    'rating' => 4.7,
                    'reviews' => 8912,
                    'image' => 'https://picsum.photos/300/300?random=304',
                    'badge' => 'BESTSELLER',
                    'slug' => 'smartphone'
                ],
                [
                    'id' => 105,
                    'brand' => 'MI',
                    'name' => 'Smart Band',
                    'price' => 2299,
                    'original_price' => 3999,
                    'discount' => 42,
                    'rating' => 4.2,
                    'reviews' => 5678,
                    'image' => 'https://picsum.photos/300/300?random=305',
                    'badge' => 'TRENDING',
                    'slug' => 'smart-band'
                ],
                [
                    'id' => 106,
                    'brand' => 'JBL',
                    'name' => 'Bluetooth Speaker',
                    'price' => 3999,
                    'original_price' => 6999,
                    'discount' => 43,
                    'rating' => 4.6,
                    'reviews' => 4321,
                    'image' => 'https://picsum.photos/300/300?random=306',
                    'badge' => 'BESTSELLER',
                    'slug' => 'bluetooth-speaker'
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
                    'badge' => 'BESTSELLER',
                    'slug' => 'hard-sided-luggage'
                ],
                [
                    'id' => 202,
                    'brand' => 'Skybags',
                    'name' => 'Backpack 40L',
                    'price' => 1499,
                    'original_price' => 2999,
                    'discount' => 50,
                    'rating' => 4.3,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=402',
                    'badge' => 'TRENDING',
                    'slug' => 'backpack-40l'
                ],
                [
                    'id' => 203,
                    'brand' => 'VIP',
                    'name' => 'Duffle Bag',
                    'price' => 1999,
                    'original_price' => 3499,
                    'discount' => 43,
                    'rating' => 4.2,
                    'reviews' => 987,
                    'image' => 'https://picsum.photos/300/300?random=403',
                    'badge' => 'NEW',
                    'slug' => 'duffle-bag'
                ],
                [
                    'id' => 204,
                    'brand' => 'Wildcraft',
                    'name' => 'Travel Backpack',
                    'price' => 2499,
                    'original_price' => 3999,
                    'discount' => 37,
                    'rating' => 4.5,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=404',
                    'badge' => 'BESTSELLER',
                    'slug' => 'travel-backpack'
                ],
            ],
            'books' => [
                [
                    'id' => 301,
                    'brand' => 'Penguin',
                    'name' => 'The Great Novel',
                    'price' => 399,
                    'original_price' => 599,
                    'discount' => 33,
                    'rating' => 4.5,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=501',
                    'badge' => 'BESTSELLER',
                    'slug' => 'the-great-novel'
                ],
                [
                    'id' => 302,
                    'brand' => 'HarperCollins',
                    'name' => 'Self Help Book',
                    'price' => 299,
                    'original_price' => 499,
                    'discount' => 40,
                    'rating' => 4.3,
                    'reviews' => 1890,
                    'image' => 'https://picsum.photos/300/300?random=502',
                    'badge' => 'TRENDING',
                    'slug' => 'self-help-book'
                ],
                [
                    'id' => 303,
                    'brand' => 'Scholastic',
                    'name' => 'Children Story Book',
                    'price' => 199,
                    'original_price' => 299,
                    'discount' => 33,
                    'rating' => 4.4,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=503',
                    'badge' => 'NEW',
                    'slug' => 'children-story-book'
                ],
                [
                    'id' => 304,
                    'brand' => 'Oxford',
                    'name' => 'Dictionary',
                    'price' => 599,
                    'original_price' => 999,
                    'discount' => 40,
                    'rating' => 4.6,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=504',
                    'badge' => 'BESTSELLER',
                    'slug' => 'dictionary'
                ],
            ],
            'sports' => [
                [
                    'id' => 401,
                    'brand' => 'Nike',
                    'name' => 'Football',
                    'price' => 1499,
                    'original_price' => 2499,
                    'discount' => 40,
                    'rating' => 4.5,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=601',
                    'badge' => 'BESTSELLER',
                    'slug' => 'football'
                ],
                [
                    'id' => 402,
                    'brand' => 'Yonex',
                    'name' => 'Badminton Racket',
                    'price' => 1999,
                    'original_price' => 3499,
                    'discount' => 43,
                    'rating' => 4.4,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=602',
                    'badge' => 'TRENDING',
                    'slug' => 'badminton-racket'
                ],
                [
                    'id' => 403,
                    'brand' => 'Cosco',
                    'name' => 'Basketball',
                    'price' => 899,
                    'original_price' => 1499,
                    'discount' => 40,
                    'rating' => 4.2,
                    'reviews' => 987,
                    'image' => 'https://picsum.photos/300/300?random=603',
                    'badge' => 'NEW',
                    'slug' => 'basketball'
                ],
                [
                    'id' => 404,
                    'brand' => 'Decathlon',
                    'name' => 'Yoga Mat',
                    'price' => 499,
                    'original_price' => 999,
                    'discount' => 50,
                    'rating' => 4.3,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=604',
                    'badge' => 'BESTSELLER',
                    'slug' => 'yoga-mat'
                ],
            ],
            'toys-baby' => [
                [
                    'id' => 501,
                    'brand' => 'LEGO',
                    'name' => 'Building Blocks',
                    'price' => 2999,
                    'original_price' => 3999,
                    'discount' => 25,
                    'rating' => 4.7,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=701',
                    'badge' => 'BESTSELLER',
                    'slug' => 'building-blocks'
                ],
                [
                    'id' => 502,
                    'brand' => 'Hot Wheels',
                    'name' => 'Toy Car Set',
                    'price' => 899,
                    'original_price' => 1499,
                    'discount' => 40,
                    'rating' => 4.4,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=702',
                    'badge' => 'TRENDING',
                    'slug' => 'toy-car-set'
                ],
                [
                    'id' => 503,
                    'brand' => 'Barbie',
                    'name' => 'Doll House',
                    'price' => 3999,
                    'original_price' => 5999,
                    'discount' => 33,
                    'rating' => 4.5,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=703',
                    'badge' => 'NEW',
                    'slug' => 'doll-house'
                ],
                [
                    'id' => 504,
                    'brand' => 'Pampers',
                    'name' => 'Baby Diapers Pack',
                    'price' => 999,
                    'original_price' => 1499,
                    'discount' => 33,
                    'rating' => 4.6,
                    'reviews' => 5678,
                    'image' => 'https://picsum.photos/300/300?random=704',
                    'badge' => 'BESTSELLER',
                    'slug' => 'baby-diapers'
                ],
            ],
            'auto-accessories' => [
                [
                    'id' => 601,
                    'brand' => 'Michelin',
                    'name' => 'Car Tyre',
                    'price' => 4999,
                    'original_price' => 6999,
                    'discount' => 28,
                    'rating' => 4.5,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=801',
                    'badge' => 'BESTSELLER',
                    'slug' => 'car-tyre'
                ],
                [
                    'id' => 602,
                    'brand' => 'Bosch',
                    'name' => 'Car Battery',
                    'price' => 5999,
                    'original_price' => 8999,
                    'discount' => 33,
                    'rating' => 4.4,
                    'reviews' => 987,
                    'image' => 'https://picsum.photos/300/300?random=802',
                    'badge' => 'TRENDING',
                    'slug' => 'car-battery'
                ],
                [
                    'id' => 603,
                    'brand' => 'Philips',
                    'name' => 'Car Headlight',
                    'price' => 1999,
                    'original_price' => 2999,
                    'discount' => 33,
                    'rating' => 4.3,
                    'reviews' => 567,
                    'image' => 'https://picsum.photos/300/300?random=803',
                    'badge' => 'NEW',
                    'slug' => 'car-headlight'
                ],
                [
                    'id' => 604,
                    'brand' => '3M',
                    'name' => 'Car Cleaning Kit',
                    'price' => 799,
                    'original_price' => 1499,
                    'discount' => 46,
                    'rating' => 4.2,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=804',
                    'badge' => 'BESTSELLER',
                    'slug' => 'car-cleaning-kit'
                ],
            ],
            'genz-trends' => [
                [
                    'id' => 701,
                    'brand' => 'Urbanic',
                    'name' => 'Oversized T-Shirt',
                    'price' => 599,
                    'original_price' => 1299,
                    'discount' => 54,
                    'rating' => 4.3,
                    'reviews' => 3456,
                    'image' => 'https://picsum.photos/300/300?random=901',
                    'badge' => 'TRENDING',
                    'slug' => 'oversized-tshirt'
                ],
                [
                    'id' => 702,
                    'brand' => 'Boat',
                    'name' => 'Wireless Earbuds',
                    'price' => 1999,
                    'original_price' => 3999,
                    'discount' => 50,
                    'rating' => 4.5,
                    'reviews' => 5678,
                    'image' => 'https://picsum.photos/300/300?random=902',
                    'badge' => 'BESTSELLER',
                    'slug' => 'wireless-earbuds-genz'
                ],
                [
                    'id' => 703,
                    'brand' => 'Fastrack',
                    'name' => 'Reflex Smartwatch',
                    'price' => 2999,
                    'original_price' => 4999,
                    'discount' => 40,
                    'rating' => 4.4,
                    'reviews' => 2345,
                    'image' => 'https://picsum.photos/300/300?random=903',
                    'badge' => 'NEW',
                    'slug' => 'reflex-smartwatch'
                ],
                [
                    'id' => 704,
                    'brand' => 'Newme',
                    'name' => 'Cargo Pants',
                    'price' => 899,
                    'original_price' => 1999,
                    'discount' => 55,
                    'rating' => 4.2,
                    'reviews' => 1234,
                    'image' => 'https://picsum.photos/300/300?random=904',
                    'badge' => 'TRENDING',
                    'slug' => 'cargo-pants'
                ],
            ],
            'next-gen' => [
                [
                    'id' => 801,
                    'brand' => 'Apple',
                    'name' => 'Vision Pro',
                    'price' => 399999,
                    'original_price' => 449999,
                    'discount' => 11,
                    'rating' => 4.8,
                    'reviews' => 567,
                    'image' => 'https://picsum.photos/300/300?random=1001',
                    'badge' => 'NEW',
                    'slug' => 'vision-pro'
                ],
                [
                    'id' => 802,
                    'brand' => 'Tesla',
                    'name' => 'Powerwall',
                    'price' => 499999,
                    'original_price' => 599999,
                    'discount' => 16,
                    'rating' => 4.7,
                    'reviews' => 234,
                    'image' => 'https://picsum.photos/300/300?random=1002',
                    'badge' => 'TRENDING',
                    'slug' => 'powerwall'
                ],
                [
                    'id' => 803,
                    'brand' => 'DJI',
                    'name' => 'Drone',
                    'price' => 89999,
                    'original_price' => 129999,
                    'discount' => 30,
                    'rating' => 4.6,
                    'reviews' => 456,
                    'image' => 'https://picsum.photos/300/300?random=1003',
                    'badge' => 'BESTSELLER',
                    'slug' => 'drone'
                ],
                [
                    'id' => 804,
                    'brand' => 'Samsung',
                    'name' => 'Flex Glass',
                    'price' => 8999,
                    'original_price' => 14999,
                    'discount' => 40,
                    'rating' => 4.4,
                    'reviews' => 789,
                    'image' => 'https://picsum.photos/300/300?random=1004',
                    'badge' => 'NEW',
                    'slug' => 'flex-glass'
                ],
            ],
        ];
        
        return $allProducts[$category] ?? [];
    }
}