<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * ============================================
     * DYNAMIC PRODUCT DETAIL PAGE
     * 
     * Yeh method admin panel se add kiye gaye
     * products ko fetch karta hai aur view mein show karta hai
     * ============================================
     */
    public function show($id, $slug = null)
    {
        try {
            // 🔥 DYNAMIC: Database se product fetch karo
            $product = Product::with('category')
                ->where('id', $id)
                ->where('is_active', true)
                ->firstOrFail();
            
            // SEO friendly URL ke liye slug check
            if ($slug && $slug !== $product->slug) {
                return redirect()->route('product.detail', [
                    'id' => $product->id, 
                    'slug' => $product->slug
                ], 301);
            }
            
            // 🔥 DYNAMIC: Related products - same category ke active products
            $relatedProducts = Product::with('category')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->inStock()
                ->limit(8)
                ->get();
            
            // Agar related products kam hain to popular products dikhao
            if ($relatedProducts->count() < 4) {
                $moreProducts = Product::where('id', '!=', $product->id)
                    ->where('is_active', true)
                    ->featured()
                    ->limit(8 - $relatedProducts->count())
                    ->get();
                
                $relatedProducts = $relatedProducts->concat($moreProducts);
            }
            
            // 🎯 Save to recently viewed (session mein store karo)
            $this->addToRecentlyViewed($product);
            
            return view('front.product-detail', compact('product', 'relatedProducts'));
            
        } catch (\Exception $e) {
            Log::error('Product detail error: ' . $e->getMessage());
            abort(404, 'Product not found');
        }
    }

    /**
     * ============================================
     * SEARCH PRODUCTS
     * ============================================
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        $products = Product::with('category')
            ->where('is_active', true)
            ->search($query)
            ->paginate(24);
        
        $categories = ProductCategory::active()->get();
        
        return view('front.search-results', compact('products', 'query', 'categories'));
    }

    /**
     * Quick view product details
     */
    public function quickView($id)
    {
        $product = Product::with('category')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('front.partials.quick-view', compact('product'));
    }

    /**
     * ============================================
     * ADD TO RECENTLY VIEWED
     * Session mein store karo recently viewed products
     * ============================================
     */
    private function addToRecentlyViewed($product)
    {
        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Remove if already exists
        $recentlyViewed = array_filter($recentlyViewed, function($item) use ($product) {
            return $item['id'] != $product->id;
        });
        
        // Add to beginning
        array_unshift($recentlyViewed, [
            'id' => $product->id,
            'name' => $product->name,
            'brand' => $product->brand,
            'price' => $product->price,
            'image' => $product->main_image,
            'slug' => $product->slug,
            'url' => $product->url
        ]);
        
        // Keep only last 10
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        
        session()->put('recently_viewed', $recentlyViewed);
    }
}