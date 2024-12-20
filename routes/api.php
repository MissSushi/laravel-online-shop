<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductsController::class, 'showAll']);
Route::get('/products/{id}', [ProductsController::class, 'showOne']);
Route::post('/products', [ProductsController::class, 'store']);
Route::put('/products/{id}', [ProductsController::class, 'update']);
Route::delete('/products/{id}', [ProductsController::class, 'destroy']);

Route::post('/categories', [CategoriesController::class, 'store']);
Route::get('/categories', [CategoriesController::class, 'showAll']);
