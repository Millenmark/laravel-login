<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateRoutes extends Controller
{
    public function testRoute(Request $request)
    {
        $userData = $request->user_data;

        $email = $userData['email'];
        $name = $userData['name'];

        return response()->json(['name' => $name, 'email' => $email]);
    }
}
