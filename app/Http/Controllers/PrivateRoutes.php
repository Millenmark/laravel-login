<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateRoutes extends Controller
{
    public function profile(Request $request)
    {
        $userData = $request->user;

        $email = $userData['email'];
        $name = $userData['name'];

        return response()->json([
            'user' => [
                'name' => $name,
                'email' => $email
            ]
        ]);
    }
}
