<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\api\AboutController;
use App\Http\Controllers\api\ContactController;

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1/auth',
], function () {
    // categories routes
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('category/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // products routes
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('product/{id}', [ProductController::class, 'show'])->name('products.show');

    // carts routes
    Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('cart', [CartController::class, 'store'])->name('carts.store');
    Route::post('cart-update', [CartController::class, 'update'])->name('carts.update');
    Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // abouts routes
    Route::get('abouts/{about}', [AboutController::class, 'show'])->name('abouts.show');

    // contacts routes
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
});


