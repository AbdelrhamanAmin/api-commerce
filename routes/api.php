<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;

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

Route::middleware('auth:sanctum')->group(function () {

     // Store  Routes
     Route::get('/store', [StoreController::class, 'index']);
     Route::post('/store', [StoreController::class, 'store']);
     Route::put('/store/{id}', [StoreController::class, 'update']);



    Route::post('logout', [AuthController::class, 'logout']);
});

// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
