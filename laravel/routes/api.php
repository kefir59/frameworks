<?php

use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// стандартний маршрут користувача (можна залишити)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// наш новий маршрут для сутності menu з маленької літери
Route::apiResource('menu', MenuController::class);