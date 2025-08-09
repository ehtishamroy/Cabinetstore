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
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ContactController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/shop/door-colors', [App\Http\Controllers\ShopController::class, 'getDoorColors'])->name('shop.door-colors');
Route::get('/shop/door-styles', [App\Http\Controllers\ShopController::class, 'getDoorStyles'])->name('shop.door-styles');

// Test route to verify shop functionality
Route::get('/test-shop', function () {
    return redirect()->route('shop');
})->name('test-shop');

Route::get('/product/{doorColorId}/{slug?}', [App\Http\Controllers\ShopController::class, 'showProduct'])->name('product.show');
Route::get('/products/by-subcategory/{subcategoryId}', [App\Http\Controllers\ShopController::class, 'getProductsBySubcategory'])->name('products.by-subcategory');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Contact form submission
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/create-payment-intent', [App\Http\Controllers\CheckoutController::class, 'createPaymentIntent'])->name('checkout.create-payment-intent');
Route::post('/checkout/process-payment', [App\Http\Controllers\CheckoutController::class, 'processPayment'])->name('checkout.process-payment');
Route::get('/checkout/success/{orderId}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Order Tracking Routes
Route::get('/track-order', [App\Http\Controllers\OrderTrackingController::class, 'index'])->name('track-order');
Route::post('/track-order', [App\Http\Controllers\OrderTrackingController::class, 'track'])->name('track-order.search');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel Routes (Protected by AdminMiddleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::patch('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment-status');
    
    Route::get('/products', function () {
        return view('admin.products');
    })->name('admin.products');
    
    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('admin.categories');
    
    Route::resource('blog', App\Http\Controllers\Admin\BlogController::class, ['as' => 'admin']);
    
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/settings/shipping', [App\Http\Controllers\Admin\SettingController::class, 'getShippingSettings'])->name('admin.settings.shipping');

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
    
    // AJAX route to get categories for a specific product line
    Route::get('product-lines/{productLine}/categories', [ProductController::class, 'getCategoriesForProductLine'])->name('admin.product-lines.categories');
    
    // AJAX route to get products for a specific category/subcategory
    Route::get('products/by-category/{categoryId}', [ProductController::class, 'getProductsByCategory'])->name('admin.products.by-category');
    Route::get('products/by-subcategory/{subcategoryId}', [ProductController::class, 'getProductsBySubcategory'])->name('admin.products.by-subcategory');
});

// Public route for shipping settings (used by checkout and cart)
Route::get('/api/shipping-settings', [App\Http\Controllers\Admin\SettingController::class, 'getShippingSettings'])->name('api.shipping-settings');

