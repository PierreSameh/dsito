<?php

use App\Http\Controllers\Customer\FavoriteController;
use App\Http\Controllers\Customer\PlaceOrderController;
use App\Http\Controllers\Customer\NegotiateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('customer')->group(function () {
    //Auth
    Route::post('/register', [AuthController::class, 'register']);


    //Favorite
    Route::post("/favorite/add", [FavoriteController::class, 'add'])->middleware('auth:sanctum,customer');
    Route::post("/favorite/edit", [FavoriteController::class, 'edit'])->middleware('auth:sanctum,customer');
    Route::post("/favorite/delete", [FavoriteController::class, 'delete'])->middleware('auth:sanctum,customer');
    Route::get("/favorite/get", [FavoriteController::class, 'get'])->middleware('auth:sanctum,customer');
    Route::get("/favorite/get-all", [FavoriteController::class, 'getAll'])->middleware('auth:sanctum,customer');

    //Place Order
    Route::post('/place-order', [PlaceOrderController::class, 'placeOrder'])->middleware('auth:sanctum,customer');

    //Negotiate
    Route::post('/order/propose', [NegotiateController::class, 'proposePrice'])->middleware('auth:sanctum,customer');
    Route::post('/order/respond-propose', [NegotiateController::class, 'respondToProposal'])->middleware('auth:sanctum,customer');
});
