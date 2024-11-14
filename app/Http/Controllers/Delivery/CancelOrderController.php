<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\OrderCancel;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;

class CancelOrderController extends Controller
{
    use HandleResponseTrait;

    public function getRequests(Request $request){
        $delivery = $request->user();
        $lastOrder = $delivery->orders()
        ->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->latest()->first();
        $cancel = OrderCancel::where('order_id', $lastOrder->id)->where('status', 'pending')->latest()->first();
        if ($lastOrder && $cancel) {
            return $this->handleResponse(
                true,
                "",
                [],
                [
                    "cancel" => $cancel
                ],
                []
                );
        }
        return $this->handleResponse(
            false,
            __("order.no cancel requests"),
            [],
            [],
            []
        );
    }
}
