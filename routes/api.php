<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User signing in
Route::post('/account/login', 'AuthController@login')->middleware(['validate-api-key'])->name('login');

// User signing up
Route::post('/account/register', 'AuthController@register')->middleware(['validate-api-key'])->name('register');

// PROTECTED: User Profile
Route::get('/account/profile', 'PrivateRoutes@profile')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('profile');
