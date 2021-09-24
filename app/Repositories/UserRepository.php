<?php

namespace App\Repositories;

use App\Contracts\Repositories\ContactInformationRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function assignRole(int $id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'roleDescription' => 'required|string'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid fields.'
            ], 400);
        }
        $integrity = check_integrity(User::class, $id, Auth::user());
        if ($integrity) return $integrity;
        $user = User::find($id);
        $user->assignRole($request->input('roleDescription'));
        return new UserResource($user);
    }
}
