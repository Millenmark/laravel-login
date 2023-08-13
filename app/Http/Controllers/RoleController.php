<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoleCollection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create([
            'role_name' => $request->input('roleName'),
            'role_permissions' => serialize($request->input('rolePermissions'))
        ]);

        return response()
            ->json([
                'message' => 'Role Created Successfully ',
                'status' => 'Created',
                'code' => 201,
            ], 201)
            ->header('Content-Type', 'application/json');
    }

    /**
     * 
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role->fill([
                'role_name' => $request->input('roleName') ?? $role->role_name,
                'role_permissions' => serialize($request->input('rolePermissions')) ?? $role->role_permissions,
            ])->save();

            return response()->json([
                'message' => 'Role updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Check if the role is associated with any user
        if ($role->users()->count() > 0) {
            // Respond with a message indicating that the role cannot be deleted
            return response()->json(['message' => 'Role cannot be deleted as it is associated with a user'], 409);
        }

        // Soft delete the role
        $role->delete();

        // Respond with a success message
        return response()->json(['message' => 'Role deleted successfully']);
    }

    /**
     * RESTORING A SINGLE ROLE
     */
    public function restore($id)
    {
        $role = Role::onlyTrashed()->find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->restore();

        return response()->json(['message' => 'Role restored successfully ']);
    }
}
