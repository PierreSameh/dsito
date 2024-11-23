<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularPlace extends Model
{
    protected $fillable = [
        "title",
        "description",
        "images",
        "address",
        "lng",
        "lat"
    ];

}
