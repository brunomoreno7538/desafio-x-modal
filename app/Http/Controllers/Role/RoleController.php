<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    /*
     * Show all roles in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'rolesCount' => $roles->count(),
            'roles' => $roles,
        ]);
    }

    /*
     * Store a newly created role in storage.
     *
     * @param  \App\Http\Requests\RoleRequest   $request
     * @return \App\Http\Resources\RoleResource
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->all());
        return new RoleResource($role);
    }

    /*
     * Updates an existing role.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\RoleRequest   $request
      * @return \App\Http\Resources\RoleResource
     */
    public function update(int $id, RoleRequest $request)
    {
        $integrity = check_integrity(Role::class, $id);
        if ($integrity) {
            return  $integrity;
        }
        $role = Role::find($id);
        $role->description = $request->input('description');
        return new RoleResource($role);
    }

    /*
     * Delete an existing role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $integrity = check_integrity(Role::class, $id);
        if ($integrity) {
            return  $integrity;
        }
        $role = Role::find($id);
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role successfully deleted.'
        ], 200);
    }
}
