<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Traits\HandleResponseTrait;
use App\Traits\SendMailTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    use HandleResponseTrait, SendMailTrait;


    public function register(Request $request) {
        try {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            "username"=> ['required', 'unique:customers,username'],
            'email' => ['nullable','email'],
            'phone' => ['required',
            'string','unique:customers,phone'],
            'password' => ['required',
            'string','min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[A-Za-z\d\W]+$/u',
            'confirmed'],
            'fcm_token'=> ['nullable','string']
        ], [
            "password.regex" => __('validation.regex'),
            "required"=> __('validation.required'),
            "string"=> __('validation.string'),
            "max"=> __('validation.max.string'),
            "email"=> __('validation.email'),
            "unique"=> __('validation.unique'),
            "numeric"=> __('validation.numeric'),
            "regex"=> __('validation.regex'),
            "confirmed"=> __('validation.confirmed'),
            "phone.regex"=> __('validation.regex')

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

        $user = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'full_name' => $request->first_name . " " . $request->last_name,
            'username'=> $request->username,
            'email' => $request->email,
            'phone'=> $request->phone,
            'password' => Hash::make($request->password),
            'fcm_token'=> $request->fcm_token ?? null
        ]);

        if ($user) {
            $code = rand(1000, 9999);

            $user->last_otp = Hash::make($code);
            $user->last_otp_expire = Carbon::now()->addMinutes(10)->timezone('Africa/Cairo');
            $user->save();
            $message = __("registration.Your Authentication Code is") . $code;

            $this->sendEmail($user->email,"OTP", $message);
        }


        $token = $user->createToken('token')->plainTextToken;




        return $this->handleResponse(
            true,
            __('registration.signed up successfully'),
            [],
            [
                "user" => $user,
                "token" => $token,
                // "fcm_token"=> $user->fcm_token
            ],
            []
        );


        } catch (\Exception $e) {
            return $this->handleResponse(
                false,
                // __('strings.error_signup'),
                "",
                [
                    $e->getMessage()
                ],
                [],
                []
            );
        }


    } 

}

