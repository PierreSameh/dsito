<?php

use App\Http\Controllers\Customer\FavoriteController;
use App\Http\Controllers\Customer\PlaceOrderController;
use App\Http\Controllers\Customer\NegotiateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\CancelOrderController;
use App\Http\Controllers\Customer\OrderController;

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
    Route::get('/place-order/active', [PlaceOrderController::class, 'getActive'])->middleware('auth:sanctum,customer');
    Route::post('/place-order/active-cancel', [PlaceOrderController::class, 'cancel'])->middleware('auth:sanctum,customer');

    //Order
    Route::get('/order/active', [OrderController::class, 'getActive'])->middleware("auth:sanctum,customer");
    Route::get('/order/get/last-completed', [OrderController::class, 'getLast'])->middleware('auth:sanctum,customer');

    //Negotiate
    Route::post('/order/propose', [NegotiateController::class, 'proposePrice'])->middleware('auth:sanctum,customer');
    Route::post('/order/respond-propose', [NegotiateController::class, 'respondToProposal'])->middleware('auth:sanctum,customer');
    Route::get('/order/get-proposals', [NegotiateController::class, 'getProposals'])->middleware('auth:sanctum,customer');

    //Cancel Order
    Route::post("/order/cancel-request", [CancelOrderController::class, "sendRequest"])->middleware('auth:sanctum,customer');
    Route::get('/order/cancel-requests/get', [CancelOrderController::class, 'getRequests'])->middleware('auth:sanctum,customer');
    Route::post('/order/cancel/respond', [CancelOrderController::class, 'respond'])->middleware('auth:sanctum,customer');

    //Rate Order
    Route::post('/order/rate', [OrderController::class, 'rate'])->middleware('auth:sanctum,customer');
});
