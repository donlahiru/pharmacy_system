<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('view/{id}', [CustomerController::class, 'show']);
        Route::post('create', [CustomerController::class, 'store']);
        Route::patch('update/{id}', [CustomerController::class, 'update']);
        Route::delete('delete/{id}', [CustomerController::class, 'delete']);
        Route::delete('destroy/{id}', [CustomerController::class, 'destroy']);
    });

    Route::prefix('medication')->group(function () {
        Route::get('/', [MedicationController::class, 'index']);
        Route::get('view/{id}', [MedicationController::class, 'show']);
        Route::post('create', [MedicationController::class, 'store']);
        Route::patch('update/{id}', [MedicationController::class, 'update']);
        Route::delete('delete/{id}', [MedicationController::class, 'delete']);
        Route::delete('destroy/{id}', [MedicationController::class, 'destroy']);
    });
});
