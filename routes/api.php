<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/signup', [SignupController::class, 'signup']);
    Route::get('/logout', [LogoutController::class, 'logout']);
});
