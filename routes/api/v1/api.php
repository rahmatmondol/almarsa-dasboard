<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use  App\Http\Controllers\api\CategoryController;


Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'v1/auth',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::apiResource('categories', CategoryController::class)->except('store', 'update', 'destroy');
    Route::apiResource('products', ProductController::class)->except('store', 'update', 'destroy');
    Route::apiResource('carts', CartController::class);
    Route::apiResource('abouts', AboutController::class)->only('show');
    Route::apiResource('contacts', ContactController::class)->only('show');
});