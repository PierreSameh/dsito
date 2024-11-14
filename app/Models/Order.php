<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "place_order_id",
        "delivery_id",
        "price",
        "rate",
        "status",
        "delivery_time"
    ];

    public function placeOrder(){
        return $this->belongsTo(PlaceOrder::class, 'place_order_id');
    }

    public function delivery(){
        return $this->belongsTo(Customer::class, 'delivery_id');
    }

    public function cancel(){
        return $this->hasOne(OrderCancel::class);
    }
}
