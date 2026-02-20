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

// Single Product Page (with optional slug for SEO)
Route::get('/product/{id}/{slug?}', [ProductController::class, 'show'])->name('product.detail');

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