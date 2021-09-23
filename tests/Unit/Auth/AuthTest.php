<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_api_auth_successfully()
    {
        $user = User::factory()->create();
        $userData = [
            'email' => $user->email,
            'password' => 'password',
        ];
        $this->json('POST', route('auth.login'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_api_auth_fails_user_not_found()
    {
        $userData = [
            'email' => time() . rand(0, 999) . 'email@email.com',
            'password' => time() . rand(0, 999),
        ];
        $this->json('POST', route('auth.login'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'The email or password is incorrect.',
            ]);
    }

    public function test_api_auth_fails_missing_fields()
    {
        $userData = [
            'email' => time() . rand(0, 999) . 'email@email.com',
        ];
        $this->json('POST', route('auth.login'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.'
            ]);
    }
}
