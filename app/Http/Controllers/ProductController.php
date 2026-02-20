<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Sample product data (in real project, database se aayega)
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
                    ]
                ],
                'colors' => ['White/Black', 'Black/Red', 'Blue/White'],
                'sizes' => ['7', '8', '9', '10', '11'],
                'in_stock' => true,
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
                ],
                'colors' => ['Black', 'White', 'Grey', 'Navy'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'in_stock' => true,
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
        
        return view('front.product-detail', compact('product', 'relatedProducts'));
    }
}