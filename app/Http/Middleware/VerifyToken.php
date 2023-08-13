<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) {
            $authorizationHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            if (!Token::validate($token, env('JWT_SECRET'))) {
                return response()->json([
                    'message' => 'Invalid Authorization Token',
                ], 400);
            } else {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
