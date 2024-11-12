<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\PlaceOrder;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Http\Request;
use App\Traits\HandleResponseTrait;
use Illuminate\Support\Facades\Validator;
class PlaceOrderController extends Controller
{
    use HandleResponseTrait;

    public function placeOrder(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "favorite_from" => "nullable|numeric|exists:favorites,id",
                "favorite_to" => "nullable|numeric|exists:favorites,id",
                "address_from" => "required_if:favorite_from,null",
                "lng_from" => "required_if:favorite_from,null",
                "lat_from" => "required_if:favorite_from,null",
                "address_to" => "required_if:favorite_to,null",
                "lng_to" => "required_if:favorite_to,null",
                "lat_to" => "required_if:favorite_to,null",
                "price" => "required|numeric",
                "details" => "required|string|max:1000",
                "payment_method" => "required|in:cash,wallet"
            ],[
                "numeric" => __('validation.numeric'),
                "exists" => __('validation.exists'),
                "required" => __("validation.required"),
                "string" => __("validation.string"),
                "max" => __("validation.max.string"),
                "payment_method.in" => "choose cash or wallet with the same spelling"
            ]);

            if($validator->fails()){
                return $this->handleResponse(
                    false,
                    "",
                    [$validator->errors()->first()],
                    [],
                    []
                );
            }

            $user = $request->user();
            //Check if customer placed an order and still active
            $lastPlacedOrder = PlaceOrder::where('customer_id', $user->id)
            ->where('status', 'pending')->latest()->first();
            //Check if customer has an order accepted by a driver
            $lastOrder = PlaceOrder::where('customer_id', $user->id)
            ->whereHas('order', function ($query){
                $query->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery']);
            })->with('order', 'order.delivery')->latest()->first();
            //Customer can't place an order while he's on an active one
            if($lastOrder ||  $lastPlacedOrder){
                return $this->handleResponse(
                    false,
                    __('order.many at the moment'),
                    [],
                    [],
                    []
                );
            }
            if($request->payment_method == "wallet"){
                $wallet = $user->wallet()->first();
                if($wallet->balance < $request->price){
                    return $this->handleResponse(
                        false,
                        __("order.no enough balance"),
                        [],
                        [],
                        []
                    );
                }
            }
            $addressFrom = $lngFrom = $latFrom = null;
            $addressTo = $lngTo = $latTo = null;
            if($request->favorite_from){
                $favoriteFrom = Favorite::find($request->favorite_from);
                if($favoriteFrom){
                    $addressFrom = $favoriteFrom->address;
                    $lngFrom = $favoriteFrom->lng;
                    $latFrom = $favoriteFrom->lat;
                } else {
                return $this->handleResponse(
                    false,
                    __('favorite.undefined address') . " from",
                    [],
                    [],
                    []
                );
                }
            }
            if($request->favorite_to){
                $favoriteTo = Favorite::find($request->favorite_to);
                if($favoriteTo){
                    $addressTo = $favoriteTo->address;
                    $lngTo = $favoriteTo->lng;
                    $latTo = $favoriteTo->lat;
                } else {
                return $this->handleResponse(
                    false,
                    __('favorite.undefined address') . " to",
                    [],
                    [],
                    []
                );
                }
            }

            $placeOrder = PlaceOrder::create([
                "customer_id" => $user->id,
                "address_from" => $request->favorite_from ? $addressFrom : $request->address_from,
                "lng_from" => $request->favorite_from ? $lngFrom : $request->lng_from,
                "lat_from" => $request->favorite_from ? $latFrom : $request->lat_from,
                "address_to" => $request->favorite_to ? $addressTo : $request->address_to,
                "lng_to" => $request->favorite_to ? $lngTo : $request->lng_to,
                "lat_to" => $request->favorite_to ? $latTo : $request->lat_to,
                "price" => $request->price,
                "details" => $request->details,
                "payment_method" => $request->payment_method
            ]);
            
            return $this->handleResponse(
                true,
                __('order.placed successfully'),
                [],
                [],
                $placeOrder
            );

        } catch (\Exception $e) {

            return $this->handleResponse(
                false,
                "",
                [$e->getMessage()],
                [],
                []
            );
        }
    }
}
