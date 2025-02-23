<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\api\AboutController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;

// guest routes
Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1',
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('forget-password', [AuthController::class, 'forgotPassword'])->name('forget-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1/auth',
], function () {

    // user routes
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::post('register-admin', [AuthController::class, 'registerAdmin'])->name('register-admin');

    // users management
    // Route::get('users', [AuthController::class, 'users'])->name('users.index');
    // Route::get('user/{id}', [AuthController::class, 'user'])->name('users.show');
    // Route::put('user/{id}', [AuthController::class, 'update'])->name('users.update');
    // Route::delete('user/{id}', [AuthController::class, 'destroy'])->name('users.destroy');

    // carts routes
    Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    Route::post('cart', [CartController::class, 'store'])->name('carts.store');
    Route::post('cart-update', [CartController::class, 'update'])->name('carts.update');
    Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

    // wishlists routes
    Route::get('wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('wishlist', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::post('wishlist-update', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::delete('wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');

    //wish to cart
    Route::post('wish-to-cart', [WishlistController::class, 'addToCart'])->name('wishlists.addToCart');
    Route::post('order-again', [OrderController::class, 'orderAgain'])->name('order.again');

    // orders routes
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('order', [OrderController::class, 'store'])->name('orders.store');
    Route::put('order/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('order/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // address routes
    Route::get('get-addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('add-address', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('update-address/{id}', [AddressController::class, 'update'])->name('addresses.store');
    Route::delete('delete-address/{id}', [AddressController::class, 'destroy'])->name('addresses.store');
});


// guest routes
Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1/',
], function () {
    Route::get('home', [HomeController::class, 'homePage'])->name('home.index');
    Route::get('shop', [ShopController::class, 'shopPage'])->name('shop.index');
    Route::get('about', [AboutController::class, 'show'])->name('abouts.show');
    Route::get('contact', [ContactController::class, 'show'])->name('contacts.index');

    // categories routes
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('category/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // products routes
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('product/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('product-search', [ProductController::class, 'search'])->name('products.search');
});
