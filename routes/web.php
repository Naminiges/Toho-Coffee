<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Public Routes (Accessible by Everyone)
|--------------------------------------------------------------------------
*/

// Landing Page & Guest Product Catalog
Route::get('/', [UserController::class, 'landingPage'])->name('welcome');
Route::get('/products', [ProductController::class, 'guestKatalog'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// AJAX Routes for Dynamic Functionality
Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/api/products/category/{category}', [ProductController::class, 'getByCategory'])->name('products.by-category');

/*
|--------------------------------------------------------------------------
| Guest Routes (Only Accessible When Not Logged In)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Registration Routes
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

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // API Routes for Authentication Check
    Route::get('/api/auth/check', [AuthController::class, 'checkAuth'])->name('auth.check');
});

/*
|--------------------------------------------------------------------------
| User Routes (Role: User)
|--------------------------------------------------------------------------
*/

Route::middleware([CheckRole::class.':user'])->group(function () {
    // Product Catalog
    Route::get('/user/katalog', [ProductController::class, 'userKatalog'])->name('user-katalog');
    
    // Shopping Cart Management
    Route::get('/user/keranjang', [CartController::class, 'showCart'])->name('user-keranjang');
    Route::post('/user/keranjang/tambah', [CartController::class, 'addToCart'])->name('user-keranjang-tambah');
    Route::put('/user/keranjang/update/{id_cart}', [CartController::class, 'updateQuantity'])->name('user-keranjang-update');
    Route::delete('/user/keranjang/hapus/{id_cart}', [CartController::class, 'removeItem'])->name('user-keranjang-hapus');
    
    // Checkout Process
    Route::get('/user/keranjang/checkout', [CartController::class, 'checkout'])->name('user-checkout');
    Route::post('/user/keranjang/checkout/process', [CartController::class, 'processCheckout'])->name('user-checkout-process');
    
    // Order History & Management
    Route::get('/user/riwayat', [OrderController::class, 'userRiwayat'])->name('user-riwayat');
    Route::post('/user/riwayat/{orderId}', [OrderController::class, 'updateStatus'])->name('user-ambil-pesanan');
    Route::get('/user/riwayat/detail-pesanan/{id}', [OrderController::class, 'userDetailPesanan'])->name('user-detail-pesanan');
    
    // Invoice
    Route::get('/invoice/{orderId}', [OrderController::class, 'invoice'])->name('invoice');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: Admin)
|--------------------------------------------------------------------------
*/

Route::middleware([CheckRole::class.':admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin-dashboard');
    
    // Product Management
    Route::get('/admin/manajemen-produk', [ProductController::class, 'adminIndex'])->name('admin-manajemen-produk');
    Route::get('/admin/manajemen-produk/tambah-produk', [ProductController::class, 'create'])->name('admin-tambah-produk');
    Route::post('/admin/manajemen-produk/tambah-produk', [ProductController::class, 'store'])->name('admin-produk-store');
    Route::get('/admin/manajemen-produk/edit-produk/{product}', [ProductController::class, 'edit'])->name('admin-edit-produk');
    Route::put('/admin/manajemen-produk/edit-produk/{product}', [ProductController::class, 'update'])->name('admin-update-produk');
    
    // User Management
    Route::get('/admin/manajemen-pelanggan', [UserController::class, 'adminCustomers'])->name('admin-manajemen-pelanggan');
    Route::get('/admin/manajemen-staff', [UserController::class, 'adminStaff'])->name('admin-manajemen-staff');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::post('/users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Order Management
    Route::get('/admin/manajemen-pesanan', [OrderController::class, 'adminManajemenPesanan'])->name('admin-manajemen-pesanan');
    Route::get('/admin/detail-pesanan/{orderId}', [OrderController::class, 'adminDetailPesanan'])->name('admin-detail-pesanan');
    Route::post('/admin/detail-pesanan/update-status/{orderId}', [OrderController::class, 'updateOrderStatus'])->name('admin-update-order-status');
    
    // Reports
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin-laporan');
    Route::get('/admin/laporan/filter', [LaporanController::class, 'filter'])->name('admin-laporan-filter');
    Route::get('/admin/laporan/print', [LaporanController::class, 'print'])->name('admin-laporan-print');
    
    // Invoice
    Route::get('/invoice/{orderId}', [OrderController::class, 'invoice'])->name('invoice');
});

/*
|--------------------------------------------------------------------------
| Staff Routes (Role: Staff)
|--------------------------------------------------------------------------
*/

Route::middleware([CheckRole::class.':staff'])->group(function () {
    // Dashboard
    Route::get('/staff', [OrderController::class, 'staffDashboard'])->name('staff-dashboard');
    
    // Product Management (Limited Access)
    Route::get('/staff/manajemen-produk', [ProductController::class, 'staffIndex'])->name('staff-manajemen-produk');
    Route::get('/staff/manajemen-produk/edit-produk/{product}', [ProductController::class, 'staffEdit'])->name('staff-edit');
    Route::put('/staff/manajemen-produk/edit-produk/{product}', [ProductController::class, 'staffUpdate'])->name('staff-update');
    
    // Order Management
    Route::get('/staff/detail-pesanan/{orderId}', [OrderController::class, 'staffDetailPesanan'])->name('staff-detail-pesanan');
    Route::post('/staff/detail-pesanan/update-status/{orderId}', [OrderController::class, 'updateOrderStatus'])->name('staff-update-order-status');

    // Invoice
    Route::get('/invoice/{orderId}', [OrderController::class, 'invoice'])->name('invoice');
});

/*
|--------------------------------------------------------------------------
| Alternative Admin Routes (Resource-based)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
});