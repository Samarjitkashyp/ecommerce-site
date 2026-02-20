<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Sample product data with complete details
    private function getProducts()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Men\'s Printed Round Neck Pure Cotton T-Shirt',
                'brand' => 'Jack & Jones',
                'price' => 799,
                'original_price' => 2499,
                'discount' => 68,
                'rating' => 4.3,
                'reviews' => 3245,
                'category' => 'fashion',
                'subcategory' => 'mens-clothing',
                'slug' => 'mens-printed-cotton-tshirt',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=201',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=201',
                        'https://picsum.photos/100/100?random=202',
                        'https://picsum.photos/100/100?random=203',
                        'https://picsum.photos/100/100?random=204',
                        'https://picsum.photos/100/100?random=205',
                        'https://picsum.photos/100/100?random=206',
                    ]
                ],
                'colors' => ['Navy Blue', 'Red', 'Black', 'Grey', 'White', 'Green'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'highlights' => [
                    '100% Pure Cotton',
                    'Regular Fit',
                    'Machine Wash',
                    'Round Neck',
                    'Half Sleeves'
                ],
                'description' => 'Elevate your casual style with this men\'s printed round neck t-shirt from Jack & Jones. Crafted from premium quality pure cotton, this t-shirt offers exceptional comfort and breathability throughout the day.',
                'in_stock' => true,
                'seller' => 'SuperComNet',
                'seller_rating' => 4.2,
                'seller_ratings_count' => 12000,
                'warranty' => '1 Year Manufacturer Warranty'
            ],
            2 => [
                'id' => 2,
                'name' => 'Men\'s Running Shoes | Lightweight | White/Black',
                'brand' => 'Puma',
                'price' => 2499,
                'original_price' => 3999,
                'discount' => 37,
                'rating' => 4.5,
                'reviews' => 5123,
                'category' => 'fashion',
                'subcategory' => 'mens-footwear',
                'slug' => 'mens-running-shoes',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=202',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=202',
                        'https://picsum.photos/100/100?random=203',
                        'https://picsum.photos/100/100?random=204',
                        'https://picsum.photos/100/100?random=205',
                        'https://picsum.photos/100/100?random=206',
                        'https://picsum.photos/100/100?random=207',
                    ]
                ],
                'colors' => ['White/Black', 'Black/Red', 'Blue/White'],
                'sizes' => ['7', '8', '9', '10', '11'],
                'highlights' => [
                    'Lightweight Design',
                    'Breathable Mesh',
                    'Cushioned Sole',
                    'Running Shoes',
                    'Durable Outsole'
                ],
                'description' => 'Experience ultimate comfort with Puma Men\'s Running Shoes. Features lightweight design, breathable mesh upper, and cushioned sole for maximum comfort during your runs.',
                'in_stock' => true,
                'seller' => 'Puma Official',
                'seller_rating' => 4.5,
                'seller_ratings_count' => 15000,
                'warranty' => '6 Months Manufacturer Warranty'
            ],
            3 => [
                'id' => 3,
                'name' => 'Men\'s Solid Regular Fit T-Shirt | Pure Cotton',
                'brand' => 'Nike',
                'price' => 1799,
                'original_price' => 2499,
                'discount' => 28,
                'rating' => 4.2,
                'reviews' => 1845,
                'category' => 'fashion',
                'subcategory' => 'mens-clothing',
                'slug' => 'mens-solid-tshirt',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=203',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=203',
                        'https://picsum.photos/100/100?random=204',
                        'https://picsum.photos/100/100?random=205',
                        'https://picsum.photos/100/100?random=206',
                    ]
                ],
                'colors' => ['Black', 'White', 'Grey', 'Navy'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'highlights' => [
                    '100% Cotton',
                    'Regular Fit',
                    'Soft Fabric',
                    'Breathable',
                    'Comfortable'
                ],
                'description' => 'Nike Men\'s Solid Regular Fit T-Shirt made from 100% pure cotton for maximum comfort. Perfect for everyday wear.',
                'in_stock' => true,
                'seller' => 'Nike Official',
                'seller_rating' => 4.6,
                'seller_ratings_count' => 25000,
                'warranty' => 'No Warranty'
            ],
            4 => [
                'id' => 4,
                'name' => 'Women\'s Skinny Fit Jeans | Stretchable | Blue',
                'brand' => 'Levi\'s',
                'price' => 2299,
                'original_price' => 3299,
                'discount' => 30,
                'rating' => 4.4,
                'reviews' => 2345,
                'category' => 'fashion',
                'subcategory' => 'womens-clothing',
                'slug' => 'womens-skinny-jeans',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=204',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=204',
                        'https://picsum.photos/100/100?random=205',
                        'https://picsum.photos/100/100?random=206',
                    ]
                ],
                'colors' => ['Blue', 'Black', 'Grey'],
                'sizes' => ['26', '28', '30', '32', '34'],
                'highlights' => [
                    'Stretchable Denim',
                    'Skinny Fit',
                    '5 Pocket Design',
                    'Button Fly',
                    'Machine Wash'
                ],
                'description' => 'Levi\'s Women\'s Skinny Fit Jeans with stretchable denim for perfect fit and comfort. Classic blue color with 5-pocket design.',
                'in_stock' => true,
                'seller' => 'Levi\'s Store',
                'seller_rating' => 4.4,
                'seller_ratings_count' => 18000,
                'warranty' => 'No Warranty'
            ],
            5 => [
                'id' => 5,
                'name' => 'Wireless Bluetooth Headphones | Noise Cancelling',
                'brand' => 'Sony',
                'price' => 3999,
                'original_price' => 5999,
                'discount' => 33,
                'rating' => 4.6,
                'reviews' => 4231,
                'category' => 'electronics',
                'subcategory' => 'audio',
                'slug' => 'wireless-headphones',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=205',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=205',
                        'https://picsum.photos/100/100?random=206',
                        'https://picsum.photos/100/100?random=207',
                        'https://picsum.photos/100/100?random=208',
                    ]
                ],
                'colors' => ['Black', 'White', 'Blue'],
                'sizes' => ['One Size'],
                'highlights' => [
                    'Active Noise Cancelling',
                    '30 Hours Battery',
                    'Bluetooth 5.0',
                    'Quick Charging',
                    'Comfort Fit'
                ],
                'description' => 'Sony Wireless Bluetooth Headphones with Active Noise Cancelling technology. Enjoy immersive sound with 30 hours of battery life.',
                'in_stock' => true,
                'seller' => 'Sony Centre',
                'seller_rating' => 4.5,
                'seller_ratings_count' => 22000,
                'warranty' => '1 Year Manufacturer Warranty'
            ],
            6 => [
                'id' => 6,
                'name' => 'Analog Watch - Men | Black Dial | Stainless Steel',
                'brand' => 'Fastrack',
                'price' => 1995,
                'original_price' => 2995,
                'discount' => 33,
                'rating' => 4.7,
                'reviews' => 6789,
                'category' => 'fashion',
                'subcategory' => 'watches',
                'slug' => 'mens-analog-watch',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=206',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=206',
                        'https://picsum.photos/100/100?random=207',
                        'https://picsum.photos/100/100?random=208',
                    ]
                ],
                'colors' => ['Black', 'Brown', 'Silver'],
                'sizes' => ['One Size'],
                'highlights' => [
                    'Stainless Steel Back',
                    'Analog Display',
                    'Water Resistant',
                    'Date Display',
                    'Leather Strap'
                ],
                'description' => 'Fastrack Analog Watch for Men with black dial and stainless steel back. Classic design with leather strap and date display.',
                'in_stock' => true,
                'seller' => 'Fastrack Store',
                'seller_rating' => 4.3,
                'seller_ratings_count' => 15000,
                'warranty' => '1 Year Manufacturer Warranty'
            ],
            101 => [
                'id' => 101,
                'name' => 'Wireless Bluetooth Headphones',
                'brand' => 'Sony',
                'price' => 3999,
                'original_price' => 5999,
                'discount' => 33,
                'rating' => 4.6,
                'reviews' => 4231,
                'category' => 'electronics',
                'subcategory' => 'audio',
                'slug' => 'wireless-headphones',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=301',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=301',
                        'https://picsum.photos/100/100?random=302',
                        'https://picsum.photos/100/100?random=303',
                    ]
                ],
                'colors' => ['Black', 'White'],
                'sizes' => ['One Size'],
                'highlights' => [
                    'Active Noise Cancelling',
                    '30 Hours Battery',
                    'Bluetooth 5.0',
                    'Quick Charging'
                ],
                'description' => 'Sony Wireless Bluetooth Headphones with Active Noise Cancelling technology.',
                'in_stock' => true,
                'seller' => 'Sony Centre',
                'seller_rating' => 4.5,
                'seller_ratings_count' => 22000,
                'warranty' => '1 Year Manufacturer Warranty'
            ],
            102 => [
                'id' => 102,
                'name' => 'Smart Watch',
                'brand' => 'Boat',
                'price' => 2499,
                'original_price' => 4999,
                'discount' => 50,
                'rating' => 4.3,
                'reviews' => 5678,
                'category' => 'electronics',
                'subcategory' => 'wearables',
                'slug' => 'smart-watch',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=302',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=302',
                        'https://picsum.photos/100/100?random=303',
                        'https://picsum.photos/100/100?random=304',
                    ]
                ],
                'colors' => ['Black', 'Blue', 'Red'],
                'sizes' => ['One Size'],
                'highlights' => [
                    'Heart Rate Monitor',
                    'SpO2 Tracking',
                    '10 Days Battery',
                    'IP68 Waterproof',
                    'Multiple Sports Modes'
                ],
                'description' => 'Boat Smart Watch with heart rate monitor, SpO2 tracking, and 10 days battery life.',
                'in_stock' => true,
                'seller' => 'Boat Official',
                'seller_rating' => 4.3,
                'seller_ratings_count' => 45000,
                'warranty' => '1 Year Manufacturer Warranty'
            ],
            201 => [
                'id' => 201,
                'name' => 'Hard-Sided Luggage Bag',
                'brand' => 'American Tourister',
                'price' => 3999,
                'original_price' => 7999,
                'discount' => 50,
                'rating' => 4.4,
                'reviews' => 1234,
                'category' => 'travel',
                'subcategory' => 'luggage',
                'slug' => 'hard-sided-luggage',
                'images' => [
                    'main' => 'https://picsum.photos/500/500?random=401',
                    'thumbnails' => [
                        'https://picsum.photos/100/100?random=401',
                        'https://picsum.photos/100/100?random=402',
                    ]
                ],
                'colors' => ['Black', 'Blue', 'Red'],
                'sizes' => ['Small', 'Medium', 'Large'],
                'highlights' => [
                    'Hard-Sided Body',
                    '4 Spinner Wheels',
                    'TSA Lock',
                    'Expandable',
                    'Lightweight'
                ],
                'description' => 'American Tourister Hard-Sided Luggage Bag with 4 spinner wheels and TSA lock.',
                'in_stock' => true,
                'seller' => 'American Tourister Store',
                'seller_rating' => 4.3,
                'seller_ratings_count' => 8000,
                'warranty' => '5 Years Warranty'
            ],
        ];
    }
    
    public function show($id, $slug = null)
    {
        $products = $this->getProducts();
        
        // Check if product exists
        if (!isset($products[$id])) {
            abort(404);
        }
        
        $product = $products[$id];
        
        // SEO friendly URL ke liye slug check
        if ($slug && $slug !== $product['slug']) {
            return redirect()->route('product.detail', ['id' => $id, 'slug' => $product['slug']]);
        }
        
        // Related products (same category ke products)
        $relatedProducts = array_filter($products, function($p) use ($product) {
            return $p['id'] !== $product['id'] && $p['category'] === $product['category'];
        });
        
        // Limit to 8 related products
        $relatedProducts = array_slice($relatedProducts, 0, 8);
        
        return view('front.product-detail', compact('product', 'relatedProducts'));
    }
}