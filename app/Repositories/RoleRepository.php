<?php

namespace App\Repositories;

use App\Contracts\Repositories\ContactInformationRepositoryInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Http\Requests\RoleRequest;

class RoleRepository implements RoleRepositoryInterface
{
    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        $roles = $this->model->all();
        return response()->json([
            'success' => true,
            'rolesCount' => $roles->count(),
            'roles' => $roles,
        ]);
    }

    public function store(RoleRequest $request): RoleResource
    {
        $role = $this->model->create($request->all());
        return new RoleResource($role);
    }

    public function update(int $id, RoleRequest $request)
    {
        $integrity = check_integrity(Role::class, $id);
        if ($integrity) {
            return  $integrity;
        }
        $role = $this->model->find($id);
        $role->description = $request->input('description');
        return new RoleResource($role);
    }

    public function delete(int $id) {
        $integrity = check_integrity(Role::class, $id);
        if ($integrity) {
            return  $integrity;
        }
        $role = $this->model->find($id);
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role successfully deleted.'
        ], 200);
    }
}
