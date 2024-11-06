<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        "first_name",
        "last_name",
        "username",
        "full_name",
        "phone",
        "email",
        "password",
        "delivery",
        "national_id",
        "id_front",
        "id_back",
        "selfie",
        "last_otp",
        "last_otp_expire",
        "verified"
    ];


    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
    
    public function placeOrders(){
        return $this->hasMany(PlaceOrder::class);
    }

}
