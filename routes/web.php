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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;

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

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

Route::post('/send-reset-code', [AuthController::class, 'sendResetCode'])
    ->name('password.send.code');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])
    ->name('password.reset.form');

Route::post('/confirm-reset', [AuthController::class, 'confirmResetPassword'])
    ->name('password.confirm.reset');

Route::post('/resend-otp', [AuthController::class, 'resendOtp'])
    ->name('password.resend');

    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

/* ADMIN */
Route::prefix('admin')
    ->middleware(['auth', 'admin:admin,nhanvien'])
    ->as('admin.')
    ->group(function () {

        // Dashboard (ADMIN + NHANVIEN)
        
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // PROFILE ADMIN + NHANVIEN
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | ADMIN + NHANVIEN
        |--------------------------------------------------------------------------
        */
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('receipts', ReceiptController::class);
        Route::resource('warehouse', WarehouseController::class);
        Route::resource('orders', OrderController::class);

        Route::get('/warehouse/search', [WarehouseController::class, 'search'])
            ->name('warehouse.search');

        Route::get('/suppliers/{id}/products', [SupplierController::class, 'getProducts'])
            ->name('suppliers.products');

        /*
        |--------------------------------------------------------------------------
        | CHỈ ADMIN
        |--------------------------------------------------------------------------
        */
        Route::middleware('admin:admin')->group(function () {

            Route::resource('accounts', AccountController::class)->except(['show']);

            Route::resource('categories', CategoryController::class);

            Route::resource('brands', BrandController::class);

            Route::prefix('reports')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('reports.index');
                Route::get('/doanhthu', [ReportController::class, 'doanhThu'])->name('reports.doanhthu');
                Route::get('/donhang', [ReportController::class, 'donHang'])->name('reports.donhang');
                Route::get('/tonkho', [ReportController::class, 'tonKho'])->name('reports.tonkho');
                Route::get('/banchay', [ReportController::class, 'banChay'])->name('reports.banchay');

                // Các route export Excel
    Route::get('/doanhthu/export', [ReportController::class, 'exportDoanhThu'])->name('reports.doanhthu.export');
    Route::get('/donhang/export', [ReportController::class, 'exportDonHang'])->name('reports.donhang.export');
    Route::get('/tonkho/export', [ReportController::class, 'exportTonKho'])->name('reports.tonkho.export');
    Route::get('/banchay/export', [ReportController::class, 'exportBanChay'])->name('reports.banchay.export');
            });
        });
    });

/* CLIENT */
//Route::prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'home'])->name('client.home');
    Route::get('/products', [ClientController::class, 'products'])->name('client.products');
    Route::get('/product/{id}', [ClientController::class, 'product'])->name('client.product');
    Route::get('/category/{id}', [ClientController::class, 'category'])->name('client.category');
    Route::get('/cart', [ClientController::class, 'cart'])->name('client.cart');
    Route::post('/cart/add/{id}', [ClientController::class, 'addToCart'])->name('client.cart.add');
    Route::get('/brand/{id}', [ClientController::class, 'brand'])->name('brand.show');
    Route::get('/orderslist', [ClientController::class, 'orderslist'])->name('client.orderslist');
    Route::get('/orders/{id}', [ClientController::class, 'orderShow'])->name('client.orders.show');   // thêm route này
    Route::put('/orders/{id}/cancel', [ClientController::class, 'orderCancel'])->name('client.orders.cancel'); // thêm route này
    Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
//});

Route::prefix('/cart')->group(function () {

    // Hiển thị giỏ hàng
    Route::get('/', [CartController::class, 'cart'])
        ->name('client.cart');

    // Thêm sản phẩm vào giỏ hàng
    Route::post('/add/{id}', [CartController::class, 'addToCart'])
        ->name('client.cart.add');

    // Cập nhật số lượng (+ / -)
    Route::put('/{id}', [CartController::class, 'updateCart'])
        ->name('client.cart.update');

    // Xóa nhiều sản phẩm đã chọn
    Route::delete('/', [CartController::class, 'removeFromCart'])
        ->name('client.cart.remove');

    // Xóa 1 sản phẩm
    Route::delete('/', [CartController::class, 'removeSelected'])
    ->name('client.cart.remove');

    // Xóa toàn bộ giỏ hàng
    Route::delete('/{id}', [CartController::class, 'removeFromCart'])
    ->name('client.cart.removeOne');
});

// CHECKOUT PAGE
Route::get('/checkout', [ClientController::class,'checkoutPage'])
    ->name('client.checkout');

// XỬ LÝ ĐẶT HÀNG + MOMO
Route::prefix('/orders')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])
        ->name('client.orders.checkout');
});

// MOMO RETURN
Route::get('/momo-return', [OrderController::class, 'momoReturn'])
    ->name('momo.return');


Route::put('/profile', [ClientController::class,'updateProfile'])->name('client.profile.update');
