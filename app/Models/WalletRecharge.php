<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRecharge extends Model
{
    protected $fillable = [
        "wallet_id",
        "photo",
        "phone_number",
        "status",
        "reject_reason"
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
