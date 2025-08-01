<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DoorStyleController;
use App\Http\Controllers\Admin\DoorColorController;
use App\Http\Controllers\Admin\ProductLineController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;

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
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel Routes (Protected by AdminMiddleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
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
    
    Route::get('/blog', function () {
        return view('admin.blog');
    })->name('admin.blog');
    
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    // User Management Routes
    Route::resource('users', UserController::class, ['as' => 'admin']);

    // Door Styles Management
    Route::resource('door-styles', DoorStyleController::class, ['as' => 'admin']);

    // Door Colors Management
    Route::resource('door-colors', DoorColorController::class, ['as' => 'admin']);

    // Product Lines Management
    Route::resource('product-lines', ProductLineController::class, ['as' => 'admin']);

    // Categories Management
    Route::resource('categories', CategoryController::class, ['as' => 'admin']);

    // Sub Categories Management
    Route::resource('sub-categories', SubCategoryController::class, ['as' => 'admin']);

    // Products Management
    Route::resource('products', ProductController::class, ['as' => 'admin']);
    Route::get('products/{product}/duplicate', [ProductController::class, 'duplicate'])->name('admin.products.duplicate');
});

