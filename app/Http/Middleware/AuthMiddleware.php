<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if ($request->header('Authorization') && $request->header('x-api-key')) {
            $authorizationHeader = $request->header('Authorization');
            $apiKey = $request->header('x-api-key');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            $secretKey = 'Hello&MikeFooBar123';
            $tokenValidation = Token::validate($token, $secretKey);

            if (!$tokenValidation) {
                return response()->json(['message' => 'Invalid Authorization Token'], 400);
            } else if ($apiKey !== env('API_KEY')) {
                return response()->json(['message' => 'Invalid Access Key'], 400);
            } else {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
