<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
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

    public function getCustomerByPhone(Request $request){
        $validator = Validator::make($request->all(), [
            "phone" => "required|string|numeric|digits:11|exists:customers,phone"
        ],[
            "phone.exists" => __("wallet.phone not registered")
        ]);

        if($validator->fails()){
            return $this->handleResponse(false,"",[$validator->errors()->first()],[],[]);
        }

        $customer = Customer::where('phone', $request->phone)
        ->select('id', 'first_name', 'last_name', 'username','phone')
        ->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                "customer" => $customer
            ],
            [
             "تقدر تستخدمها لو عايز تعرض اسم المستخدم الذي سيتم التحويل اليه، للتأكيد من ان الرقم صحيح"
            ]
        );
    }

    public function transfer(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "phone" => "required|string|numeric|digits:11|exists:customers,phone",
                "amount" => "required|numeric",
            ],[
                "phone.exists" => __("wallet.phone not registered")
            ]);

            if($validator->fails()){
                return $this->handleResponse(false,"",[$validator->errors()->first()],[],[]);
            }

            $user = $request->user();
            $sender = $user->wallet()->first();
            if($sender->balance < $request->amount){
                return $this->handleResponse(
                    false,
                    __("wallet.no enough balance"),
                    [],
                    [],
                    []
                );
            }
            $receiverUser = Customer::where('phone', $request->phone)->first();
            $receiver = $receiverUser->wallet()->first();

            $transaction = Transaction::create([
                'sender' => $sender->id,
                'receiver' => $receiver->id,
                'amount' => $request->amount,
                'type' => 'transfer',
            ]);

            //Take amount from sender
            $sender->balance -= $transaction->amount;
            $sender->save();
            //Give amount to receiver
            $receiver->balance += $transaction->amount;
            $receiver->save();
            //Set transaction completed
            $transaction->status = "completed";
            $transaction->save();

            return $this->handleResponse(
                true,
                __("wallet.send money success"),
                [],
                [
                    "wallet" => $sender->only('id', 'customer_id', 'balance'),
                    "transaction" => $transaction
                ],
                []
            );
            
        } catch (\Exception $e){
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