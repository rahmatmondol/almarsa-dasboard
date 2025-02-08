<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\api\AboutController;
use App\Http\Controllers\api\ContactController;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1/auth',
], function () {
    // categories routes
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/collections', [CategoryController::class, 'collections'])->name('categories.collections');

    // wix store routes
    Route::get('wix-collection', [CategoryController::class, 'wixCollection'])->name('wix.collection');
    // Route::get('wix-collection/{collection}', [CategoryController::class, 'wixStore-collection-single'])->name('wix.collection.single');
    // Route::get('wix-collection/{collection}/products', [CategoryController::class, 'wixStore-collection-product'])->name('wix.collection');
    // Route::get('wix-products', [ProductController::class, 'wixStore-collection'])->name('wix.collection');
    // Route::get('wix-products/{product}', [ProductController::class, 'wixStore-collection'])->name('wix.collection');


    // products routes
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // carts routes
    Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('carts', [CartController::class, 'store'])->name('carts.store');
    Route::put('carts/{cart}', [CartController::class, 'update'])->name('carts.update');
    Route::delete('carts/{cart}', [CartController::class, 'destroy'])->name('carts.destroy');

    // abouts routes
    Route::get('abouts/{about}', [AboutController::class, 'show'])->name('abouts.show');

    // contacts routes
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
});


