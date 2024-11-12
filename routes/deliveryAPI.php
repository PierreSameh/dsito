<?php

use App\Http\Controllers\Delivery\AuthController;
use App\Http\Controllers\Delivery\LocationController;
use App\Http\Controllers\Delivery\NegotiateController;
use App\Http\Controllers\Delivery\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('delivery')->group(function () {
    //Auth
    Route::post('/register', [AuthController::class, 'register']);


    //Location
    Route::post('/set-location', [LocationController::class, 'setDeliveryLocation'])->middleware('auth:sanctum,customer');

    //Orders
    Route::get('/nearby-orders', [OrderController::class, 'nearbyOrders'])->middleware('auth:sanctum,customer');
    Route::post('/order/accept', [OrderController::class, 'accept'])->middleware("auth:sanctum,customer");
    Route::get('/order/active', [OrderController::class, 'getActive'])->middleware("auth:sanctum,customer");

    //Order Status
    Route::post("/order/status/first-point", [OrderController::class, 'setFirstPoint'])->middleware('auth:sanctum,customer');
    Route::post("/order/status/received", [OrderController::class, 'setReceived'])->middleware('auth:sanctum,customer');
    Route::post("/order/status/sec-point", [OrderController::class, 'setSecPoint'])->middleware('auth:sanctum,customer');
    Route::post("/order/status/completed", [OrderController::class, 'setCompleted'])->middleware('auth:sanctum,customer');


    //Negotiate
    Route::post('/order/propose', [NegotiateController::class, 'proposePrice'])->middleware('auth:sanctum,customer');
    Route::post('/order/respond-propose', [NegotiateController::class, 'respondToProposal'])->middleware('auth:sanctum,customer');
    Route::get('/order/get-proposals', [NegotiateController::class, 'getProposals'])->middleware('auth:sanctum,customer');

});
