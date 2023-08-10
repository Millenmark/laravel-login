<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use ReallySimpleJWT\Token;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::all());

        // return UserResource::collection(User::with('role')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // $newImageName = time() . '.' . $request->avatar->extension();
        // $request->avatarUrl->move(public_path('avatars'), $newImageName);

        User::create([
            'avatar_url' => $request->input('avatarUrl'),
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phoneNumber'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'zip_code' => $request->input('zipCode'),
            'company' => $request->input('company'),
            'is_verified' => $request->input('isVerified'),
            'status' => $request->input('status') ?? 'active',
            'role_id' => $request->input('roleId'),
            'email_verified_at' => now(),
            'password' => bcrypt('123'),
        ]);

        return response()
            ->json([
                'message' => 'User Created Successfully ',
                'status' => 'Created',
                'code' => 201,
            ], 201)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function profile(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $user = User::find(Token::getPayload($token, env('JWT_SECRET'))['uid']);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
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
                'role_id' => $request->input('roleId') ?? $user->role,
                'email_verified_at' => now(),
                'password' => $request->input('password') ?? $user->password,
                'isPublic' => $request->input('isPublic') ?? $user->isPublic,
                'about' => $request->input('about') ?? $user->about,
            ])->save();

            return response()->json([
                'message' => 'User updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'avatarUrl' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time() . '.' . $request->avatarUrl->extension();

        $request->avatarUrl->move(public_path('avatars'), $imageName);


        return response()->json(['success' => 'Image uploaded successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
