<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginOtpRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class LoginOtpController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function login_verification(LoginOtpRequest $request)
    {
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status){
            return response()->json([
                "error" => $otp2
            ],401);
        }
        $user = User::where('email',$request->email)->first();
        $user->update(['otp_verified_at' => now()]);
        $success['success'] = true;
        return response([
            "success" => [
                true
            ]
        ]);
    }
}
