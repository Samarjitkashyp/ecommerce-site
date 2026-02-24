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
use App\Http\Controllers\Admin\HomeCategoryController;

Route::prefix('admin')->name('admin.')->middleware(['web', 'admin'])->group(function() {
    
    // ============================================
    // DASHBOARD
    // ============================================
    Route::controller(DashboardController::class)->group(function() {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/stats', 'getStats')->name('dashboard.stats');
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile', 'updateProfile')->name('profile.update');
        Route::get('/activity', 'activity')->name('activity');
        Route::get('/notifications', 'notifications')->name('notifications');
        Route::post('/notifications/{id}/read', 'markNotificationRead')->name('notifications.read');
    });
    
    // ============================================
    // SEARCH
    // ============================================
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    // ============================================
    // MENU MANAGEMENT
    // ============================================
    Route::prefix('menus')->name('menus.')->controller(MenuController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{menu}/edit', 'edit')->name('edit');
        Route::put('/{menu}', 'update')->name('update');
        Route::delete('/{menu}', 'destroy')->name('destroy');
        Route::post('/update-order', 'updateOrder')->name('update-order');
        Route::get('/location/{location}', 'getMenusForLocation')->name('location');
        Route::post('/{menu}/duplicate', 'duplicate')->name('duplicate');
        Route::get('/locations', 'locations')->name('locations');
    });
    
    // ============================================
    // CATEGORY MANAGEMENT
    // ============================================
    Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('/{category}/status', 'updateStatus')->name('status');
        Route::get('/tree', 'getTree')->name('tree');
    });
    
    // ============================================
    // PRODUCT MANAGEMENT
    // ============================================
    Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'destroy')->name('destroy');
        Route::get('/inventory', 'inventory')->name('inventory');
        Route::post('/stock/update', 'updateStock')->name('stock.update');
    });
    
    // ============================================
    // ORDER MANAGEMENT
    // ============================================
    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/processing', 'processing')->name('processing');
        Route::get('/completed', 'completed')->name('completed');
        Route::get('/cancelled', 'cancelled')->name('cancelled');
        Route::get('/{order}', 'show')->name('show');
        Route::post('/{order}/status', 'updateStatus')->name('status');
        Route::post('/{order}/cancel', 'cancel')->name('cancel');
        Route::get('/{order}/invoice', 'invoice')->name('invoice');
    });
    
    // ============================================
    // USER MANAGEMENT
    // ============================================
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::post('/{user}/status', 'updateStatus')->name('status');
    });
    
    // ============================================
    // SETTINGS MANAGEMENT
    // ============================================
    Route::prefix('settings')->name('settings.')->controller(SettingsController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/general', 'general')->name('general');
        Route::post('/general', 'updateGeneral')->name('general.update');
        Route::get('/seo', 'seo')->name('seo');
        Route::post('/seo', 'updateSeo')->name('seo.update');
        Route::get('/payment', 'payment')->name('payment');
        Route::post('/payment', 'updatePayment')->name('payment.update');
        Route::get('/shipping', 'shipping')->name('shipping');
        Route::post('/shipping', 'updateShipping')->name('shipping.update');
        Route::get('/email', 'email')->name('email');
        Route::post('/email', 'updateEmail')->name('email.update');
        Route::get('/system', 'system')->name('system');
        Route::post('/system', 'updateSystem')->name('system.update');
        Route::get('/api', 'api')->name('api');
        Route::post('/api', 'updateApi')->name('api.update');
    });

    // ============================================
    // 🏠 HOME CATEGORY MANAGEMENT (VERIFIED & FIXED)
    // ============================================
    Route::prefix('home-categories')->name('home-categories.')->controller(HomeCategoryController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{homeCategory}/edit', 'edit')->name('edit');
        Route::put('/{homeCategory}', 'update')->name('update');
        Route::delete('/{homeCategory}', 'destroy')->name('destroy');
        Route::post('/update-order', 'updateOrder')->name('update-order');
        Route::post('/{homeCategory}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
    });
});