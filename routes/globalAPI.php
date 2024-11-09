<?php

use App\Http\Controllers\Global\AuthController;
use App\Http\Controllers\Global\NegotiateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Auth
Route::get('/ask-email-verification-code', [AuthController::class, "askEmailCode"])->middleware('auth:sanctum,customer');
Route::post('/verify-email', [AuthController::class, "verifyEmail"])->middleware('auth:sanctum,customer');
Route::post('/change-password', [AuthController::class, "changePassword"])->middleware('auth:sanctum,customer');
Route::get('/forgot-password', [AuthController::class, "sendForgetPassword"]);
Route::post('/forgot-password-check-code', [AuthController::class, "forgetPasswordCheckCode"]);
Route::post('/forgot-password-set', [AuthController::class,'forgetPassword']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, "logout"])->middleware('auth:sanctum,customer');

