<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);

/// routes/web.php
use App\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class);

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

use App\Http\Controllers\SupplierController;
Route::resource('suppliers', SupplierController::class);

use App\Http\Controllers\BrandController;

Route::resource('brands', BrandController::class);
