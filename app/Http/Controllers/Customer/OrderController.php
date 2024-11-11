<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PlaceOrder;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HandleResponseTrait;

    public function getActive(Request $request){
        $user = $request->user();
        $lastOrder = PlaceOrder::where('customer_id', $user->id)
        ->whereHas('order', function ($query){
            $query->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery']);

        })->with('order', 'order.delivery')->latest()->first();
        if($lastOrder){
            return $this->handleResponse(
                true,
                "",
                [],
                [
                    "active_order" => $lastOrder
                ],
                []
            );
        }
        return $this->handleResponse(
            true,
            __("order.no ongoing"),
            [],
            [],
            []
        );
    }
}
