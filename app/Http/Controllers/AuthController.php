<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token;
use App\Models\User;


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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|regex:/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#%_]*[!#%_])[A-Za-z0-9!#%_]{8,32}$/',
            ],
            [
                'password.regex' => 'The password must be alphanumeric with at least one special character.',
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'message' => $validator->errors(),
                    'status' => 'Unprocessable Content',
                    'code' => 422
                ], 422)
                ->header('Content-Type', 'application/json');
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()
            ->json([
                'message' => /*$user->id . ' ' .*/ 'Account Created Successfully ',
                'status' => 'Created',
                'code' => 201
            ], 201)
            ->header('Content-Type', 'application/json');
    }
}
