<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\HandleResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\PlaceOrder;
class OrderController extends Controller
{
    use HandleResponseTrait;

    public function nearbyOrders(Request $request){
        $delivery = $request->user();
        $distanceLimit = 10;
        $earthRadius = 6371; // Radius of Earth in kilometers

        $placeOrders = PlaceOrder::select('*')
        ->selectRaw("($earthRadius * ACOS(
            COS(RADIANS(?)) * COS(RADIANS(lat_from)) *
            COS(RADIANS(lng_from) - RADIANS(?)) +
            SIN(RADIANS(?)) * SIN(RADIANS(lat_from))
        )) AS distance", [$delivery->lat, $delivery->lng, $delivery->lat])
        ->having('distance', '<=', $distanceLimit)
        ->where('status', 'pending')
        ->with(['customer' => function ($query) {
            $query->select('id','first_name', 'last_name','username', 'phone');
        }])->orderBy('distance')
        ->get();

        if(count($placeOrders) > 0){
            return $this->handleResponse(
                true,
                "",
                [],
                [
                    "nearby_orders" => $placeOrders
                ],
                []
            );
        }
        return $this->handleResponse(
            true,
            __("order.no nearby orders"),
            [],
            [],
            []
        );
    }

    public function accept(Request $request){
        $validator = Validator::make($request->all(), [
            "place_order_id" => "required|exists:place_orders,id"
        ]);
        if($validator->fails()){
            return $this->handleResponse(false, "", [$validator->errors()->first()],[],[]);
        }

        $placeOrder = PlaceOrder::findOrFail($request->place_order_id);
        $delivery = $request->user();
        $lastOrder = $delivery->orders()->
        whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->latest()->first();
        if ($lastOrder){
            return $this->handleResponse(
                false,
                __("order.many at the moment"),
                [],
                [],
                []
            );
        }
        //Check placed order status (must be pending)
        if($placeOrder->status == "pending"){
            $order = Order::create([
                "place_order_id" => $placeOrder->id,
                "delivery_id" => $delivery->id,
                "price" => $placeOrder->price
            ]);
            $placeOrder->update(["status" => "accepted"]);

            $order->load("placeOrder");
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
            false,
            __("order.not available"),
            [],
            [],
            []
        );

    }

    public function getActive(Request $request){
        $delivery = $request->user();
        $lastOrder = $delivery->orders()->
        whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->with('placeOrder')
        ->latest()->first();
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

    public function setFirstPoint(Request $request){
        $delivery = $request->user();
        $lastOrder = $delivery->orders()->
        whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->with('placeOrder')
        ->latest()->first();
        if($lastOrder){
            $lastOrder->status = "first_point";
            $lastOrder->save();
            return $this->handleResponse(
                true,
                __("order.status updated"),
                [],
                [],
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
    public function setReceived(Request $request){
        $delivery = $request->user();
        $lastOrder = $delivery->orders()->
        whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->with('placeOrder')
        ->latest()->first();
        if($lastOrder){
            $lastOrder->status = "received";
            $lastOrder->save();
            return $this->handleResponse(
                true,
                __("order.status updated"),
                [],
                [],
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
    public function setSecPoint(Request $request){
        $delivery = $request->user();
        $lastOrder = $delivery->orders()->
        whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])
        ->with('placeOrder')
        ->latest()->first();
        if($lastOrder){
            $lastOrder->status = "sec_point";
            $lastOrder->save();
            return $this->handleResponse(
                true,
                __("order.status updated"),
                [],
                [],
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
