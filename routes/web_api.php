<?php

use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'BasicAuth'], function() {
    Route::get('products_list', [ProductApiController::class, 'productList']);

    // Cart routes
    Route::post('cart_list', [CartApiController::class, 'index']);
    Route::post('add_cart', [CartApiController::class, 'addCart']);
    Route::post('edit_cart', [CartApiController::class, 'editCart']);
    Route::post('delete_cart', [CartApiController::class, 'deleteCart']);
    Route::post('checkout', [CartApiController::class, 'checkout']);
});