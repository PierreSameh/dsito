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
Route::post('/customer/change-password', [AuthController::class, "changePassword"])->middleware('auth:sanctum,customer');
Route::get('/customer/forgot-password', [AuthController::class, "sendForgetPassword"]);
Route::post('/customer/forgot-password-check-code', [AuthController::class, "forgetPasswordCheckCode"]);
Route::post('/customer/forgot-password-set', [AuthController::class,'forgetPassword']);
Route::post('/customer/login', [AuthController::class, 'login']);
Route::post('/customer/logout', [AuthController::class, "logout"])->middleware('auth:sanctum');