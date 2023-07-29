<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $payload = [
            'iat' => time(),
            'uid' => 1,
            'exp' => time() + 10,
            'iss' => 'http://laravel-login.localhost'
        ];

        $secret = 'Hello&MikeFooBar123';

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = Token::customPayload($payload, $secret);
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        //
        return "HEllo logiout";
    }

    public function register()
    {
        //
        return "Helaosd Register";
    }
}
