<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\LoginEmailOtpNotification;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::where('email', $data['email'])->count() == 1){
            throw new HttpResponseException(response([
                "error" => [
                    "email" => [
                        "email already registered"
                    ]
                ]
            ],400));
        }

        $user = new User($data);

        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)){
            throw new HttpResponseException(response([
                "error" => [
                    "message" => [
                        "email or password wrong"
                    ]
                ]
            ],401));
        }
        $user->token = Str::uuid()->toString();
        $user->notify(new LoginEmailOtpNotification());
        $user->save();

        return new UserResource($user);
    }

    public function getUser(Request $request):UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }
}
