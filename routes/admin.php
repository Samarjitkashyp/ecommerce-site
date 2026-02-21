<?php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SearchController;

Route::prefix('admin')->name('admin.')->middleware(['web', 'admin'])->group(function() {
    
    // ============================================
    // DASHBOARD
    // ============================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/activity', [DashboardController::class, 'activity'])->name('activity');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationRead'])->name('notifications.read');
    
    // ============================================
    // SEARCH
    // ============================================
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    // ============================================
    // MENU MANAGEMENT
    // ============================================
    Route::prefix('menus')->name('menus.')->group(function() {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
        Route::post('/update-order', [MenuController::class, 'updateOrder'])->name('update-order');
        Route::get('/location/{location}', [MenuController::class, 'getMenusForLocation'])->name('location');
        Route::post('/{menu}/duplicate', [MenuController::class, 'duplicate'])->name('duplicate');
        Route::get('/locations', [MenuController::class, 'locations'])->name('locations');
    });
    
    // ============================================
    // CATEGORY MANAGEMENT
    // ============================================
    Route::prefix('categories')->name('categories.')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/{category}/status', [CategoryController::class, 'updateStatus'])->name('status');
        Route::get('/tree', [CategoryController::class, 'getTree'])->name('tree');
    });
    
    // ============================================
    // PRODUCT MANAGEMENT
    // ============================================
    Route::prefix('products')->name('products.')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/inventory', [ProductController::class, 'inventory'])->name('inventory');
        Route::post('/stock/update', [ProductController::class, 'updateStock'])->name('stock.update');
    });
    
    // ============================================
    // ORDER MANAGEMENT
    // ============================================
    Route::prefix('orders')->name('orders.')->group(function() {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
        Route::get('/processing', [OrderController::class, 'processing'])->name('processing');
        Route::get('/completed', [OrderController::class, 'completed'])->name('completed');
        Route::get('/cancelled', [OrderController::class, 'cancelled'])->name('cancelled');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('status');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{order}/invoice', [OrderController::class, 'invoice'])->name('invoice');
    });
    
    // ============================================
    // USER MANAGEMENT
    // ============================================
    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/status', [UserController::class, 'updateStatus'])->name('status');
    });
    
    // ============================================
    // SETTINGS MANAGEMENT
    // ============================================
    Route::prefix('settings')->name('settings.')->group(function() {
        Route::get('/', [SettingsController::class, 'index'])->name('index'); // 👈 THIS IS admin.settings
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');
        Route::get('/seo', [SettingsController::class, 'seo'])->name('seo');
        Route::post('/seo', [SettingsController::class, 'updateSeo'])->name('seo.update');
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::post('/payment', [SettingsController::class, 'updatePayment'])->name('payment.update');
        Route::get('/shipping', [SettingsController::class, 'shipping'])->name('shipping');
        Route::post('/shipping', [SettingsController::class, 'updateShipping'])->name('shipping.update');
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('email.update');
        Route::get('/system', [SettingsController::class, 'system'])->name('system');
        Route::post('/system', [SettingsController::class, 'updateSystem'])->name('system.update');
        Route::get('/api', [SettingsController::class, 'api'])->name('api');
        Route::post('/api', [SettingsController::class, 'updateApi'])->name('api.update');
    });
});