<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderNegotiation;
use App\Models\PlaceOrder;
use App\Traits\HandleResponseTrait;
use Illuminate\Support\Facades\Validator;

class NegotiateController extends Controller
{
    use HandleResponseTrait;
    public function proposePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'place_order_id' => 'required|exists:place_orders,id',
            'proposed_price' => 'required|numeric|min:0',
        ]);
        
        if ($validator->fails()) {
            return $this->handleResponse(false, '', [$validator->errors()->first()],[],[]);
        }

        $placeOrder = PlaceOrder::findOrFail($request->place_order_id);

        $proposer = $request->user();
        // Create a new negotiation proposal
        $negotiation = OrderNegotiation::create([
            'place_order_id' => $placeOrder->id,
            'delivery_id' => $proposer->id,
            'proposed_price' => $request->proposed_price,
            'status' => 'pending',
        ]);
        return $this->handleResponse(
            true,
            __("order.propose sent"),
            [],
            [
                'negotiation' => $negotiation,
            ],
            []
        );
    }

    public function respondToProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'negotiation_id' => 'required|exists:order_negotiations,id',
            'status' => 'required|in:accepted,rejected',

        ]);
        
        if ($validator->fails()) {
            return $this->handleResponse(false, '', [$validator->errors()->first()],[],[]);
        }
        
        $negotiation = OrderNegotiation::findOrFail($request->negotiation_id);

 
        $delivery = $request->user();
        if ($negotiation->delivery_id == $delivery->id){
            return $this->handleResponse(
                false,
                __("order.can not respond self"),
                [],
                [],
                []
            );
        }
        // Update negotiation status
        $negotiation->status = $request->status;
        $negotiation->save();

        if ($negotiation->status == 'accepted') {
            $order = Order::create([
                "place_order_id" => $negotiation->placeOrder->id,
                "delivery_id" => $delivery->id,
                "price" => $negotiation->proposed_price
            ]);

            return $this->handleResponse(
                true,
                __("order.start order"),
                [],
                [
                    "order" => $order,
                ],
                []
            );
        }
        return $this->handleResponse(
            true,
            __("order.propose respond recorded"),
            [],
            [
                'negotiation' => $negotiation,
            ],
            []
        );
    }
}


