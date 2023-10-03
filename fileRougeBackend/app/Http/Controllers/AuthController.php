<?php

namespace App\Http\Controllers;

use App\Traits\HttpResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResp;

    public function login(Request $request)
    {

        if (!Auth::attempt($request->only("email", "password"))) {
            return response([
                "message" => "Invalid credentials"
            ],);
        }
        $user = Auth::user();
        $token = $user->createToken("token")->plainTextToken;
        $data = [
            "user" => $user,
            "token" => $token
        ];
        return $this->success(200, "", $data);
    }



    public function logout()
    {
        Auth::logout();
        // Cookie::forget("token");
        // return response([
        //     "message" => "success"
        // ]);
    }
}
