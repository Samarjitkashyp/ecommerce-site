<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Front Routes
Route::get('/', function () {
    return view('front.index');
})->name('home');

Route::get('/about', function () {
    return view('front.about');
})->name('about');

Route::get('/services', function () {
    return view('front.services');
})->name('services');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

// Category page route
Route::get('/category/{category}', function($category) {
    return view('front.category');
})->name('category');