<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    protected $fillable = [
        "order_id",
        "delivery_id",
        "customer_id",
        "reason",
        "status"
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    // public function customer(){
    //     return $this->belongsTo(Customer::class, 'customer_id');
    // }

    // public function delivery(){
    //     return $this->belongsTo(Customer::class, 'delivery_id');
    // }
}
