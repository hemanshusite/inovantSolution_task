<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('loginPage');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'CustomAuth'], function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product routes
    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::post('products/fetch', [ProductController::class, 'fetchProducts'])->name('products.fetch');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('product/view/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('product/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('product/stock/{id}', [ProductController::class, 'stockUpdate'])->name('product.stock');
    Route::post('product/stock/update', [ProductController::class, 'stockUpdateSave'])->name('product.stock.update');
    Route::get('product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

    // Orders routes
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::post('orders/fetch', [OrderController::class, 'fetchOrders'])->name('orders.fetch');
    Route::get('order/view/{id}', [OrderController::class, 'show'])->name('order.show');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

