<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use App\Models\User;

class ForSuperadminAndAdmin
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
            $allowedRoles = ['superadmin', 'admin'];

            // dd($user->role->role_name);
            if (!Token::validate($token, env('JWT_SECRET'))) {
                return response()->json([
                    'message' => 'Invalid Authorization Token',
                    'status' => 'Bad Request',
                    'code' => 400
                ], 400);
            } else if (!in_array($user->role->role_name, $allowedRoles)) {
                return response()->json([
                    'message' => 'You don\'t have the permission',
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
