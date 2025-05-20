<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/products', function () {
    return view('products');
})->name('products');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');
Route::get('/user/katalog', function () {
    return view('user.katalog');
})->name('user-katalog');
Route::get('/user/keranjang', function () {
    return view('user.keranjang');
})->name('user-keranjang');
Route::get('/user/checkout', function () {
    return view('user.checkout');
})->name('user-checkout');

// Route::prefix('admin')->group(function () {

// });

// Route::prefix('user')->group(function () {

// });