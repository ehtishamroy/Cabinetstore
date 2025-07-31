<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/store', function () {
    return view('store');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/product', function () {
    return view('product');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/contact', function () {
    return view('contact');
});

