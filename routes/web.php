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
use App\Http\Controllers\DashboardController;
 use App\Http\Controllers\ReportController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Products
Route::resource('products', ProductController::class);

// Categories
Route::resource('categories', CategoryController::class);

// Suppliers
Route::resource('suppliers', SupplierController::class);

Route::get('/suppliers/{id}/products', [SupplierController::class, 'getProducts']);

// Brands
Route::resource('brands', BrandController::class);

// Receipts
Route::resource('receipts', ReceiptController::class);

// Warehouse
Route::resource('warehouse', WarehouseController::class);
Route::get('/warehouse/search', [WarehouseController::class, 'search']);

//
Route::resource('accounts', AccountController::class)->except(['show']);

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
});
