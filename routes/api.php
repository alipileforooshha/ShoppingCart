<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('',[ProductController::class, 'index'])->name('products.index');  
    Route::post('/create',[ProductController::class, 'create'])->name('products.create');  
});

Route::prefix('carts')->group(function () {
    Route::get('',[CartController::class, 'index'])->name('carts.index');
    Route::post('/add',[CartController::class, 'add'])->name('carts.add');  
    Route::post('/remove',[CartController::class, 'remove'])->name('carts.remove');  
});

Route::get('checkout',[CartController::class, 'checkout'])->name('checkout');