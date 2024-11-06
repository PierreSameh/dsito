<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        "customer_id",
        "balance"
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
