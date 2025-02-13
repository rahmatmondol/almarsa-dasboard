<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\api\CategoryController as ApiCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Models\Contact;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name(
        'logout'
    );

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
