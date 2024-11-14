<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCancel;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CancelOrderController extends Controller
{
    use HandleResponseTrait;


    public function sendRequest(Request $request){
        $validator = Validator::make($request->all(), [
            "order_id" => "required|numeric|exists:orders,id",
            "reason" => "required|string|max:1000"
        ]);

        if($validator->fails()){
            return $this->handleResponse(false, "", [$validator->errors()->first()],[],[]);
        }

        $customer = $request->user();
        $order = Order::where('id', $request->order_id)->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])->first();
        if($order){
        $cancel = OrderCancel::create([
            "order_id" => $request->order_id,
            "customer_id" => $customer->id,
            "reason" => $request->reason
        ]);
        return $this->handleResponse(
            true,
            __("order.cancel request sent"),
            [],
            [],
            []
        );
        }
        return $this->handleResponse(
            false,
            __('order.not available'),
            [],
            [],
            []
        );
    }
}
