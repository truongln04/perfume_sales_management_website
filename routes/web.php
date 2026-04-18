<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
<<<<<<< HEAD
use App\Http\Controllers\DashboardController;
 use App\Http\Controllers\ReportController;
=======
use App\Http\Controllers\AuthController;
>>>>>>> 4da78598506ce60f280ec74e0fd51323d061f9ad

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

/* AUTH */
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')
        ->middleware('auth')
        ->name('logout');
});

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->as('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Suppliers
    Route::resource('suppliers', SupplierController::class);
    Route::get('/suppliers/{id}/products', [SupplierController::class, 'getProducts'])
        ->name('admin.suppliers.products');

    // Brands
    Route::resource('brands', BrandController::class);

    // Receipts
    Route::resource('receipts', ReceiptController::class);

<<<<<<< HEAD
Route::resource('orders', OrderController::class);

// Cho Blade
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');



Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/doanhthu', [ReportController::class, 'doanhThu'])->name('reports.doanhthu');
    Route::get('/donhang', [ReportController::class, 'donHang'])->name('reports.donhang');
    Route::get('/tonkho', [ReportController::class, 'tonKho'])->name('reports.tonkho');
    Route::get('/banchay', [ReportController::class, 'banChay'])->name('reports.banchay');
=======
    // Warehouse
    Route::resource('warehouse', WarehouseController::class);
    Route::get('/warehouse/search', [WarehouseController::class, 'search'])
        ->name('admin.warehouse.search');

    // Accounts
    Route::resource('accounts', AccountController::class)->except(['show']);

    // Orders
    Route::resource('orders', OrderController::class);
>>>>>>> 4da78598506ce60f280ec74e0fd51323d061f9ad
});
