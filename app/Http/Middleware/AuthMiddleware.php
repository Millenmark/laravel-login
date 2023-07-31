<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use App\Models\User;

class AuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if ($request->header('Authorization') && $request->header('x-api-key')) {
            $authorizationHeader = $request->header('Authorization');
            $apiKey = $request->header('x-api-key');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            $secret = 'Hello&MikeFooBar123';

            if (!Token::validate($token, $secret)) {
                return response()->json(['message' => 'Invalid Authorization Token'], 400);
            } else if ($apiKey !== env('API_KEY')) {
                return response()->json(['message' => 'Invalid Access Key'], 400);
            } else {

                // dd(Token::getPayload($token, $secret));

                $user = User::find(Token::getPayload($token, $secret)['uid']);

                if (!$user) {
                    return response()->json(['message' => 'User not found'], 404);
                }

                $email = $user->email;
                $name = $user->name;

                $request->merge(['user_data' => [
                    'name' => $name,
                    'email' => $email,
                ]]);

                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
