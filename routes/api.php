<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/customer/register', [AuthController::class, 'register']);
Route::get('/customer/ask-email-verfication-code', [AuthController::class, "askEmailCode"])->middleware('auth:sanctum,customer');
Route::post('/customer/verify-email', [AuthController::class, "verifyEmail"])->middleware('auth:sanctum,customer');
