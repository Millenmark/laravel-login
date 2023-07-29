<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivateRoutes extends Controller
{
    public function testRoute()
    {
        return 'Hello from test route';
    }
}
