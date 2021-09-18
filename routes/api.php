<?php

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
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::post('/signup', [UserController::class, 'signup']);
