<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', function () {
    return view('front.index');
})->name('home');

// Category Page
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category');

// ============================================
// SINGLE PRODUCT PAGE ROUTE
// ============================================
Route::get('/product/{id}/{slug?}', function($id, $slug = null) {
    // Product data (in real project, yeh database se aayega)
    $products = [
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
            'slug' => 'mens-printed-cotton-tshirt'
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
            'slug' => 'mens-running-shoes'
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
            'slug' => 'mens-solid-tshirt'
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
            'slug' => 'womens-skinny-jeans'
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
            'slug' => 'wireless-headphones'
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
            'slug' => 'mens-analog-watch'
        ],
    ];
    
    // Check if product exists
    if (!isset($products[$id])) {
        abort(404);
    }
    
    $product = $products[$id];
    
    // Agar slug diya hai aur match nahi karta toh redirect karo
    if ($slug && $slug !== $product['slug']) {
        return redirect()->route('product.detail', ['id' => $id, 'slug' => $product['slug']]);
    }
    
    return view('front.product-detail', compact('product'));
})->name('product.detail');

// Other routes...
Route::get('/search', function() {
    return view('front.search');
})->name('search');

Route::get('/cart', function() {
    return view('front.cart');
})->name('cart');

Route::get('/checkout', function() {
    return view('front.checkout');
})->name('checkout');

Route::get('/product/{id}/{slug?}', [ProductController::class, 'show'])->name('product.detail');