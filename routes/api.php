<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/products', [ProductsController::class, 'showAll']);
    Route::get('{id}/products', [ProductsController::class, 'showOne']);
    Route::post('/products', [ProductsController::class, 'store']);
    Route::delete('/products', [ProductsController::class, 'destroy']);
    Route::put('/products', [ProductsController::class, 'update']);
    
    // Route::get('/categories', [CategoriesController::class, 'index']);
    // Route::post('/categories', [CategoriesController::class, 'index']);
    // Route::delete('/categories', [CategoriesController::class, 'index']);
    // Route::put('/categories', [CategoriesController::class, 'index']);


    // Route::get('/images', [ImagesController::class, 'index']);

});