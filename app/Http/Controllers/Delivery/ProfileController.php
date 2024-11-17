<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use HandleResponseTrait;

    public function get(Request $request){
        $user = Customer::where('id', $request->user()->id)
        ->select("id", "full_name", "username", "phone", "delivery_rate", "picture", "delivery", "verified")
        ->first();
        return $this->handleResponse(
            true,
            "",
            [],
            [
                "profile" => $user
            ],
            []
        );
    }

    public function edit(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "full_name" => ['nullable', "string", 'regex:/^([A-Za-zÀ-ÖØ-öø-ÿ]+(?:\s+[A-Za-zÀ-ÖØ-öø-ÿ]+){3})$/'],
                'phone' => ['nullable','string','unique:customers,phone'],
                'picture'=> 'nullable|image|mimes:jpeg,png,jpg,gif'
            ]);
    
    
            if ($validator->fails()) {
                return $this->handleResponse(
                false,
                "",
                [$validator->errors()->first()],
                [],
                []
                );
            }
            $user = $request->user();
            if($request->full_name){
            $user->full_name = $request->full_name;
            }
            if($request->phone){
            $user->phone = $request->phone;
            }
            if ($request->picture) {
                $imagePath = $request->file('picture')->store('/storage/profile', 'public');
                $user->picture = $imagePath;
            }
            $user->save();
            
            return $this->handleResponse(
                true,
                __("profile.info updated"),
                [],
                [
                   "user" => $user,
                ],
                []
            );
            } catch (\Exception $e) {
                return $this->handleResponse(
                    false,
                    __("profile.error info update"),
                    [
                        // $e->getMessage()
                    ],
                    [],
                    []
                );
            }
    }
}
