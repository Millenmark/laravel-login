<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateRoutes extends Controller
{
    public function profile(Request $request)
    {
        // dd($request->user);
        $userData = $request->user;

        return response()->json([
            'user' => [
                'id' => $userData['id'],
                'firstName' => $userData['firstName'],
                'lastName' => $userData['lastName'],
                'email' => $userData['email']
            ]
        ]);
    }
}
