<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// ============================================
// AUTH ROUTES
// ============================================
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ACCOUNT ROUTES (Protected by Auth Middleware)
// ============================================
Route::prefix('account')->name('account.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [AccountController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::post('/profile/password', [AccountController::class, 'updatePassword'])->name('profile.password');
    
    // Orders Routes
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AccountController::class, 'orderDetails'])->name('order.detail');
    
    // Wishlist Routes
    Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.delete');
    Route::post('/wishlist/{wishlist}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move');
    
    // Addresses Routes
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('address.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('address.delete');
    Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('address.default');
});

// ============================================
// PUBLIC ROUTES
// ============================================

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
// CART ROUTES
// ============================================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
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