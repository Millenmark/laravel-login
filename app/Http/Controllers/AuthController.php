<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $secret = 'Hello&MikeFooBar123';

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = Token::customPayload([
                'uid' => Auth::user()->id,
                'exp' => time() +  3600,
            ], $secret);
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        return "HEllo logiout";
    }

    // Registering a user
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => [
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
            ],
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'message' => $validator->errors()->first(),
                    'status' => 'Unprocessable Content',
                    'code' => 422
                ], 422)
                ->header('Content-Type', 'application/json');
        }

        User::create([
            'fname' => $request->input('firstName'),
            'lname' => $request->input('lastName'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()
            ->json([
                'message' => /*$user->id . ' ' .*/ 'Account Created Successfully ',
                'status' => 'Created',
                'code' => 201
            ], 201)
            ->header('Content-Type', 'application/json');
    }
}
