<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::post('/create',[ProductController::class, 'create'])->name('products.create');  
});

Route::prefix('carts')->group(function () {
    Route::get('',[CartController::class, 'index'])->name('carts');
    Route::post('/add',[CartController::class, 'add'])->name('carts.add');  
    Route::post('/remove',[CartController::class, 'remove'])->name('carts.remove');  
});