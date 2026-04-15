<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('accounts', AccountController::class)->except(['show']);

Route::resource('orders', OrderController::class);

Route::resource('products', ProductController::class);

Route::resource('categories', CategoryController::class);

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::resource('suppliers', SupplierController::class);

Route::resource('brands', BrandController::class);
