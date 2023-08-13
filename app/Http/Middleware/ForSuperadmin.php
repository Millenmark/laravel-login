<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use App\Models\User;

class ForSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) {
            $authorizationHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authorizationHeader);

            $user = User::find(Token::getPayload($token, env('JWT_SECRET'))['uid']);

            // dd($user->role->role_name);
            if (!Token::validate($token, env('JWT_SECRET'))) {
                return response()->json([
                    'message' => 'Invalid Authorization Token',
                    'status' => 'Bad Request',
                    'code' => 400
                ], 400);
            } else if ($user->role->role_name !== "superadmin") {
                return response()->json([
                    'message' => 'You don\'t have the permission to access this route',
                    'status' => 'Forbidden',
                    'code' => 403
                ], 403);
            } else {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
