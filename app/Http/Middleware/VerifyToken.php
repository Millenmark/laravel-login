<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use App\Models\User;

class VerifyToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) {
            $authorizationHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            $secret = 'Hello&MikeFooBar123';

            if (!Token::validate($token, $secret)) {
                return response()->json([
                    'message' => 'Invalid Authorization Token',
                ], 400);
            } else {

                // dd(Token::getPayload($token, $secret));
                // dd(Token::getHeader($token, $secret));

                $user = User::find(Token::getPayload($token, $secret)['uid']);

                if (!$user) {
                    return response()->json([
                        'message' => 'User not found',
                    ], 404);
                }

                $request->merge([
                    'user' => [
                        'id' => Token::getPayload($token, $secret)['uid'],
                        'firstName' => $user->fname,
                        'lastName' => $user->lname,
                        'email' => $user->email,
                    ]
                ]);

                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
