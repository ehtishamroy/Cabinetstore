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

