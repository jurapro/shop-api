<?php

use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);
Route::get('/products', [ProductController::class, 'index']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->middleware(['auth:api']);
    Route::middleware(['can:isUser,App\Models\User'])->group(function () {
        Route::post('/cart/{product}', [ProductCartController::class, 'addProduct']);
        Route::get('/cart', [ProductCartController::class, 'show']);
    });
});
