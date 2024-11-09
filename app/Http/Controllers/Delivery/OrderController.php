<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandleResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Traits\CalculateDistanceTrait;

class OrderController extends Controller
{
    use HandleResponseTrait, CalculateDistanceTrait;

    public function nearbyOrders(Request $request){
        
    }
}
