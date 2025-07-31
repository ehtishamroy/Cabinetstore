<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');



Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/post', function () {
    return view('post');
})->name('post');

Route::get('/claim', function () {
    return view('claim');
})->name('claim');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');

// Authentication Routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('admin.orders');
    
    Route::get('/products', function () {
        return view('admin.products');
    })->name('admin.products');
    
    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('admin.categories');
    
    Route::get('/customers', function () {
        return view('admin.customers');
    })->name('admin.customers');
    
    Route::get('/blog', function () {
        return view('admin.blog');
    })->name('admin.blog');
    
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

