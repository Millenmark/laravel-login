<?php

use App\Models\Role;
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
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin-admin'])
    ->name('users-all');

Route::get('/users/{user}', 'UserController@show')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin-admin'])
    ->name('users-show');

Route::post('/users', 'UserController@store')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('user-create');

Route::post('/users/upload', 'UserController@upload')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('users-avatar-upload');

Route::put('/users/{user}', 'UserController@update')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('users-update');

Route::delete('/users/{user}', 'UserController@destroy')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('users-delete');


/**
 * ROLE ROUTES
 */
Route::get('/roles', 'RoleController@index')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin-admin'])
    ->name('role-all');

Route::get('/roles/{role}', 'RoleController@show')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('role-show');

Route::post('/roles', 'RoleController@store')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('role-create');

Route::put('/roles/{role}', 'RoleController@update')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('role-update');

Route::put('/roles/restore/{id}', 'RoleController@restore')
    ->middleware([
        'validate-access-token', 'validate-api-key',
        // 'superadmin'
    ])
    ->name('role-restore');

Route::delete('/roles/{role}', 'RoleController@destroy')
    ->middleware(['validate-access-token', 'validate-api-key', 'superadmin'])
    ->name('role-delete');
