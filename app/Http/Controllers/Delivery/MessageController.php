<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Order;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\SendMessageEvent;

class MessageController extends Controller
{
    use HandleResponseTrait;

    public function send(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "message" => "required|string|max:1000"
            ]);

            if($validator->fails()){
                return $this->handleResponse(
                    false,"",[$validator->errors()->first()],[],[]
                );
            }

            $delivery = $request->user();
            $order = Order::where('delivery_id', $delivery->id)->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])->latest()->first();
            if(!$order){
                return $this->handleResponse(
                    false,
                    __("order.no ongoing"),
                    [],
                    [],
                    []
                );
            }
            $message = Message::create([
                "order_id" => $order->id,
                "sender_type" => "delivery",
                "sender_id" => $delivery->id,
                "message" => $request->message
            ]);

            broadcast(new SendMessageEvent($message))->toOthers();
            
            return $this->handleResponse(
                true,
                __('order.message sent'),
                [],
                [],
                []
            );
        } catch (\Exception $e){
            return $this->handleResponse(
                false,
                __('wallet.server error'),
                [
                    // $e->getMessage()
                ],
                [],
                []
            );
        }
    }

    public function get(Request $request){
        $delivery = $request->user();

        $order = Order::where('delivery_id', $delivery->id)->whereNotIn('status', ['completed', 'cancelled_user', 'cancelled_delivery'])->latest()->first();
        if($request->order_id){
            $order = Order::findOrFail($request->order_id);
        }
        if(!$order){
            return $this->handleResponse(
                false,
                __("order.no ongoing"),
                [],
                [],
                []
            );
        }
        $messages = Message::where('order_id', $order->id)->orderBy('created_at', 'asc')->get();
        
        return $this->handleResponse(
            true,
            "",
            [],
            [
                "messages" => $messages
            ],
            []
        );
    }
}
