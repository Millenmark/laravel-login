<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAPIKey
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('x-api-key')) {
            $apiKey = $request->header('x-api-key');

            if ($apiKey !== env('API_KEY')) {
                return response()->json(['message' => 'Invalid Access Key'], 400);
            } else {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
