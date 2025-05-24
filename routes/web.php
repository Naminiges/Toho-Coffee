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
Route::get('/invoice', function () {
    return view('invoice');
});


// user

Route::get('/user/katalog', function () {
    return view('user.katalog');
})->name('user-katalog');
Route::get('/user/keranjang', function () {
    return view('user.keranjang');
})->name('user-keranjang');
Route::get('/user/keranjang/checkout', function () {
    return view('user.checkout');
})->name('user-checkout');
Route::get('/user/riwayat', function () {
    return view('user.riwayat');
})->name('user-riwayat');
Route::get('/user/riwayat/detail-pesanan', function () {
    return view('user.detail-pesanan');
})->name('user-detail-pesanan');
Route::get('/user/profil', function () {
    return view('user.profil');
})->name('user-profil');

// admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin-dashboard');
Route::get('/admin/manajemen-produk', function () {
    return view('admin.manajemen-produk');
})->name('admin-manajemen-produk');
Route::get('/admin/tambah-produk', function () {
    return view('admin.tambah-produk');
})->name('admin-tambah-produk');
Route::get('/admin/edit-produk', function () {
    return view('admin.edit-produk');
})->name('admin-edit-produk');



// Route::prefix('admin')->group(function () {

// });

// Route::prefix('user')->group(function () {

// });