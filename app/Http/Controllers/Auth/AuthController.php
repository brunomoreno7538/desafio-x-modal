<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userData = $request->only(
            'name',
            'email',
            'password',
            'password_confirmation'
        );
        $userData['password'] = bcrypt($request->password);
        $user = User::create($userData);
        $user->assignRole('USER');
        $accessToken = $user->createToken($userData['email'])->accessToken;
        $contactInformation = ContactInformation::create([
            'user_id' => $user->id,
            'cellphone_number' => $request->input('cellphoneNumber'),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'userDetails' => [
                'name' => $user->name,
                'email' => $user->email,
                'cellphoneNumber' => $contactInformation->cellphone_number,
            ],
            'accessToken' => $accessToken
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'The email or password is incorrect.'
            ], 401);
        }
        $user = Auth::user();
        $accessToken = Auth::user()->createToken($user->email)->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'Authentication performed successfully.',
            'userDetails' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'accessToken' => $accessToken
        ], 200);
    }
}
