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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

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

    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

/* ADMIN */
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->as('admin.')
    ->group(function () {
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
            ->name('suppliers.products');

        // Brands
        Route::resource('brands', BrandController::class);

        // Receipts
        Route::resource('receipts', ReceiptController::class);

        // Warehouse
        Route::resource('warehouse', WarehouseController::class);
        Route::get('/warehouse/search', [WarehouseController::class, 'search'])->name('warehouse.search');

        // Accounts
        Route::resource('accounts', AccountController::class)->except(['show']);

        // Orders
        Route::resource('orders', OrderController::class);

        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/doanhthu', [ReportController::class, 'doanhThu'])->name('reports.doanhthu');
            Route::get('/donhang', [ReportController::class, 'donHang'])->name('reports.donhang');
            Route::get('/tonkho', [ReportController::class, 'tonKho'])->name('reports.tonkho');
            Route::get('/banchay', [ReportController::class, 'banChay'])->name('reports.banchay');
        });
    });

/* CLIENT */
// Route::prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'home'])->name('client.home');
    Route::get('/products', [ClientController::class, 'products'])->name('client.products');
    Route::get('/product/{id}', [ClientController::class, 'product'])->name('client.product');
    Route::get('/category/{id}', [ClientController::class, 'category'])->name('client.category');
    Route::get('/cart', [ClientController::class, 'cart'])->name('client.cart');
    Route::get('/orderslist', [ClientController::class, 'orderslist'])->name('client.orderslist');
    Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
// });
