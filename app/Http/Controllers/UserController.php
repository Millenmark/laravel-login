<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'avatarUrl' => 'nullable',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:10',
            'company' => 'nullable|string|max:255',
            'isVerified' => 'nullable|boolean',
            'status' => 'nullable|string|in:active,banned',
            'role' => 'nullable|string|in:admin,user',
        ]);

        User::create([
            'avatar_url' => $request->input('avatarUrl'),
            'fname' => $request->input('firstName'),
            'lname' => $request->input('lastName'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phoneNumber'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'zip_code' => $request->input('zipCode'),
            'company' => $request->input('company'),
            'isVerified' => $request->input('isVerified'),
            'status' => $request->input('status'),
            'role' => $request->input('role'),
            'email_verified_at' => now(),
            'password' => bcrypt('123'),
        ]);

        return response()
            ->json([
                'message' => 'User Created Successfully ',
                'status' => 'Created',
                'code' => 201,
            ], 201)
            ->header('Content-Type', 'application/json');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
