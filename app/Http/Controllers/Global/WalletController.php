<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletRecharge;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    use HandleResponseTrait;

    public function get(Request $request){
        $user = $request->user();
        $wallet = Wallet::where('customer_id', $user->id)
        ->with('recharges')
        ->select('id', 'customer_id', 'balance')
        ->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                "wallet" => $wallet
            ],
            []
        );
    }

    public function deposit(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            "photo" => 'required|image|mimes:jpeg,png,jpg,gif',
            "phone" => 'required|string|numeric|digits:11'
        ]);

        if($validator->fails()){
            return $this->handleResponse(false,"",[$validator->errors()->first()],[],[]);
        }

        $user = $request->user();
        $wallet = $user->wallet()->first();

        $imagePath = $request->file('photo')->store('/storage/recharges', 'public');
        $recharge = WalletRecharge::create([
            "wallet_id" => $wallet->id,
            "photo" => $imagePath,
            "phone_number" => $request->phone
        ]);

        return $this->handleResponse(
            true,
            __("wallet.deposit sent"),
            [],
            [
                "recharge" => $recharge
            ],
            []
        );
    } catch (\Exception $e) {
        return $this->handleResponse(
            false,
            __("wallet.server error"),
            [
                // $e->getMessage()
            ],
            [],
            []
        );
    }
    }

}
