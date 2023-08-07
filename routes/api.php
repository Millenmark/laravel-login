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

/**
 * AUTH ROUTES
 */
Route::post('/account/login', 'AuthController@login')->middleware(['validate-api-key'])->name('login');
Route::post('/account/register', 'AuthController@register')->middleware(['validate-api-key'])->name('register');

/**
 * PROTECTED: User Profile
 */
Route::get('/account/profile', 'UserController@profile')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('profile');


/**
 * USER ROUTES
 */
Route::get('/users', 'UserController@index')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-all');

Route::get('/users/{user}', 'UserController@show')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-show');

Route::post('/users', 'UserController@store')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-create');

Route::post('/users/upload', 'UserController@upload')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-avatar-upload');

Route::put('/users/{user}', 'UserController@update')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-update');

Route::delete('/users/{user}', 'UserController@destroy')
    ->middleware(['validate-access-token', 'validate-api-key'])
    ->name('users-delete');
