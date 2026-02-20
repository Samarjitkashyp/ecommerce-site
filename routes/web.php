<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

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

// Single Product Page
Route::get('/product/{id}/{slug?}', [ProductController::class, 'show'])->name('product.detail');

// Search Page
Route::get('/search', function() {
    return view('front.search');
})->name('search');

// Checkout Page
Route::get('/checkout', function() {
    return view('front.checkout');
})->name('checkout');

// ============================================
// CART ROUTES - COMPLETELY FIXED
// ============================================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');  // THIS IS cart.index
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/save-for-later', [CartController::class, 'saveForLater'])->name('save');
    Route::post('/move-to-cart', [CartController::class, 'moveToCart'])->name('move');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});