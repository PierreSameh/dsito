<?php

use App\Http\Controllers\Delivery\ActivitiesController;
use App\Http\Controllers\Delivery\AuthController;
use App\Http\Controllers\Delivery\CancelOrderController;
use App\Http\Controllers\Delivery\LocationController;
use App\Http\Controllers\Delivery\NegotiateController;
use App\Http\Controllers\Delivery\OrderController;
use App\Http\Controllers\Delivery\ProfileController;
use App\Http\Middleware\CheckDeliveryAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('delivery')->group(function () {
    //Auth
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware(['auth:sanctum,customer', CheckDeliveryAccess::class])->group(function () {
    //Location
    Route::post('/set-location', [LocationController::class, 'setDeliveryLocation']);

    //Orders
    Route::get('/nearby-orders', [OrderController::class, 'nearbyOrders']);
    Route::post('/order/accept', [OrderController::class, 'accept']);
    Route::get('/order/active', [OrderController::class, 'getActive']);
    Route::get('/order/get/last-completed', [OrderController::class, 'getLast']);

    //Order Status
    Route::post("/order/status/first-point", [OrderController::class, 'setFirstPoint']);
    Route::post("/order/status/received", [OrderController::class, 'setReceived']);
    Route::post("/order/status/sec-point", [OrderController::class, 'setSecPoint']);
    Route::post("/order/status/completed", [OrderController::class, 'setCompleted']);


    //Negotiate
    Route::post('/order/propose', [NegotiateController::class, 'proposePrice']);
    Route::post('/order/respond-propose', [NegotiateController::class, 'respondToProposal']);
    Route::get('/order/get-proposals', [NegotiateController::class, 'getProposals']);

    //Cancel Order
    Route::get('/order/cancel-requests/get', [CancelOrderController::class, 'getRequests']);
    Route::post('/order/cancel/respond', [CancelOrderController::class, 'respond']);
    Route::post("/order/cancel-request", [CancelOrderController::class, "sendRequest"]);

    //Rate Order
    Route::post('/order/rate', [OrderController::class, 'rate']);

    //Profile
    Route::get('/profile/get', [ProfileController::class, 'get']);
    Route::post('/profile/edit', [ProfileController::class, 'edit']);

    //Activities
    Route::get('/activities/completed-all', [ActivitiesController::class, 'getCompletedAll']);
    Route::get('/activities/completed-paginate', [ActivitiesController::class, 'getCompletedPaginate']);
    Route::get('/activities/cancelled-all', [ActivitiesController::class, 'getCancelledAll']);
    Route::get('/activities/cancelled-paginate', [ActivitiesController::class, 'getCancelledPaginate']);
    });
});
