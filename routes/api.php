<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/products', [ProductsController::class, 'showAll']);
    Route::get('/products/{id}', [ProductsController::class, 'showOne']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::delete('/products', [ProductsController::class, 'destroy']);
    Route::put('/products', [ProductsController::class, 'update']);

    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::get('/categories', [CategoriesController::class, 'showAll']);
});
