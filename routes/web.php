<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;

// Home Page
Route::get('/', function () {
    return view('front.index');
})->name('home');

// 🟢 FIXED: Auth Routes with proper naming
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Category Routes
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category');

// Product Routes
Route::get('/product/{id}/{slug?}', [ProductController::class, 'show'])->name('product.detail');

// Cart Routes (public - session based)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/save', [CartController::class, 'saveForLater'])->name('save');
    Route::post('/move', [CartController::class, 'moveToCart'])->name('move');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// Protected Routes (require login)
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Account Routes
    Route::prefix('account')->name('account.')->group(function() {
        Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [AccountController::class, 'uploadAvatar'])->name('profile.avatar');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AccountController::class, 'orderDetails'])->name('order.detail');
        Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
        Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    });
    
    // Address Routes
    Route::prefix('address')->name('address.')->group(function () {
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
        Route::post('/{address}/default', [AddressController::class, 'setDefault'])->name('default');
    });
    
    // Order Routes
    Route::prefix('order')->name('order.')->group(function () {
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{order}/track', [OrderController::class, 'track'])->name('track');
    });
    
    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::post('/', [WishlistController::class, 'store'])->name('store');
        Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
        Route::post('/{wishlist}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
    });
});

// Search Route
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Include admin routes
require __DIR__.'/admin.php';