<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/products', function () {
    return view('products');
})->name('products');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
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
Route::get('/profil', function () {
    return view('profil');
})->name('user-profil');
Route::get('/invoice', function () {
    return view('invoice');
})->name('invoice');

// admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin-dashboard');
Route::get('/admin/manajemen-produk', function () {
    return view('admin.manajemen-produk');
})->name('admin-manajemen-produk');
Route::get('/admin/manajemen-produk/tambah-produk', function () {
    return view('admin.tambah-produk');
})->name('admin-tambah-produk');
Route::get('/admin/manajemen-produk/edit-produk', function () {
    return view('admin.edit-produk');
})->name('admin-edit-produk');
Route::get('/admin/manajemen-pesanan', function () {
    return view('admin.manajemen-pesanan');
})->name('admin-manajemen-pesanan');
Route::get('/admin/manajemen-pesanan/detail-pesanan', function () {
    return view('admin.detail-pesanan');
})->name('admin-detail-pesanan');
Route::get('/admin/manajemen-pelanggan', function () {
    return view('admin.manajemen-pelanggan');
})->name('admin-manajemen-pelanggan');
Route::get('/admin/manajemen-staff', function () {
    return view('admin.manajemen-staff');
})->name('admin-manajemen-staff');
Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->name('admin-laporan');

// staff
Route::get('/staff', function () {
    return view('staff.staff-dashboard');
})->name('staff-dashboard');
Route::get('/staff/detail-pesanan', function () {
    return view('staff.staff-detail');
})->name('staff-detail-pesanan');
Route::get('/staff/manajemen-produk', function () {
    return view('staff.staff-produk');
})->name('staff-manajemen-produk');
Route::get('/staff/manajemen-produk/edit-produk', function () {
    return view('staff.staff-edit');
})->name('staff-edit');

Route::middleware('guest')->group(function () {
    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Password Reset Routes
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
});

// Logout Route - hanya bisa diakses jika sudah login
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes - hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // API Routes untuk check authentication
    Route::get('/api/auth/check', [AuthController::class, 'checkAuth'])->name('auth.check');
    });

// Rute registrasi
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);

// Route::prefix('admin')->group(function () {

// });

// Route::prefix('user')->group(function () {

// });