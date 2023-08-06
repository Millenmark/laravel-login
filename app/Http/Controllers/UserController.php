<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ]);
        }

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
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
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
            'isPublic' => 'nullable|boolean',
            'about' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $user->fill([
                'avatar_url' => $request->input('avatarUrl') ?? $user->avatar_url,
                'fname' => $request->input('firstName') ?? $user->fname,
                'lname' => $request->input('lastName') ?? $user->lname,
                'email' => $request->input('email') ?? $user->email,
                'phone_number' => $request->input('phoneNumber') ?? $user->phone_number,
                'address' => $request->input('address') ?? $user->address,
                'country' => $request->input('country') ?? $user->country,
                'state' => $request->input('state') ?? $user->state,
                'city' => $request->input('city') ?? $user->city,
                'zip_code' => $request->input('zipCode') ?? $user->zip_code,
                'company' => $request->input('company') ?? $user->company,
                'isVerified' => $request->input('isVerified') ?? $user->isVerified,
                'status' => $request->input('status') ?? $user->status,
                'role' => $request->input('role') ?? $user->role,
                'email_verified_at' => now(),
                'password' => $request->input('password') ?? $user->password,
                'isPublic' => $request->input('isPublic') ?? $user->isPublic,
                'about' => $request->input('about') ?? $user->about,
            ])->save();

            return response()->json([
                'message' => 'User updated successfully.',
            ]);
        } catch (\Exception $e) {
            // If an exception occurs during the save operation, you can catch it here.
            return response()->json([
                'message' => 'An error occurred while updating the user.',
                'error' => $e->getMessage(), // Optionally, you can include the error message for debugging purposes.
            ], 500);
        }
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
