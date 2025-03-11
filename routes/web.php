<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\api\CategoryController as ApiCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardControlller;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardControlller::class, 'index'])->name('dashboard');

    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name(
        'logout'
    );

    // notification Routes
    Route::get('/notification-delete', [Notification::class, 'delete'])->name('notification.delete');
    Route::get('/notification', [Notification::class, 'read'])->name('notification');

    //customer routes
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    });

    // categories routes
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/show/{category}', [CategoryController::class, 'show'])->name('category.show');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    // orders routes
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.list');
        Route::get('/show/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/edit/{order}', [OrderController::class, 'edit'])->name('order.edit');
        Route::get('/update/{order}', [OrderController::class, 'update'])->name('order.update');
        Route::get('/invoice/{order}', [OrderController::class, 'pdf'])->name('order.invoice');
        Route::delete('/destroy/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    });

    Route::group(['prefix' => 'settings'], function () {
        //home routes 
        Route::group(['prefix' => 'home'], function () {
            Route::get('/', [HomeController::class, 'index'])->name('home.index');
            Route::post('/store', [HomeController::class, 'store'])->name('home.store');
            Route::post('/list-store', [HomeController::class, 'listStore'])->name('home.list.store');
            Route::get('/homelist', [HomeController::class, 'homelist'])->name('home.list');
            Route::post('/edit/{id}', [HomeController::class, 'update'])->name('home.update');
            Route::post('/list-delete', [HomeController::class, 'listDelete'])->name('home.list.delete');
            Route::post('/list-update', [HomeController::class, 'listUpdate'])->name('home.list.update');
        });

        //shop routes 
        Route::group(['prefix' => 'shop'], function () {
            Route::get('/', [ShopController::class, 'index'])->name('shop.index');
            Route::post('/store', [ShopController::class, 'store'])->name('shop.store');
            Route::post('/list-store', [ShopController::class, 'listStore'])->name('shop.list.store');
            Route::get('/shoplist', [ShopController::class, 'shoplist'])->name('shop.list');
            Route::post('/edit/{id}', [ShopController::class, 'update'])->name('shop.update');
            Route::post('/list-delete', [ShopController::class, 'listDelete'])->name('shop.list.delete');
            Route::post('/list-update', [ShopController::class, 'listUpdate'])->name('shop.list.update');
        });

        //about routes 
        Route::group(['prefix' => 'about'], function () {
            Route::get('/', [AboutController::class, 'index'])->name('about.index');
            Route::post('/store', [AboutController::class, 'show'])->name('about.store');
            Route::post('/edit/{id}', [AboutController::class, 'update'])->name('about.update');
        });

        //contact routes 
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [ContactController::class, 'index'])->name('contact.index');
            Route::post('/store', [ContactController::class, 'show'])->name('contact.store');
            Route::post('/edit/{id}', [ContactController::class, 'update'])->name('contact.update');
        });
    });


    // wix store routes
    Route::get('/wix-collection', [ApiCategoryController::class, 'wixCollection'])->name('wix.collection');
});

require __DIR__ . '/auth.php';
