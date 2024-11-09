<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandleResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Traits\CalculateDistanceTrait;
use App\Models\PlaceOrder;
class OrderController extends Controller
{
    use HandleResponseTrait, CalculateDistanceTrait;

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
        }])        ->orderBy('distance')
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
}
