<?php

namespace App\Http\Controllers\User;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
