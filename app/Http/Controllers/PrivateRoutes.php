<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateRoutes extends Controller
{
    public function profile(Request $request)
    {
        // dd($request->user);

    }
}
