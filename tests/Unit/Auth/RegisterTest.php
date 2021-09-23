<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_api_auth_register_successfully()
    {
        $password = time() . rand(0, 999);
        $userData = [
            'email' => time() . rand(0, 999) . 'email@email.com',
            'password' => $password,
            'password_confirmation' => $password,
            'name' => 'Jane Doe',
            'cellphoneNumber' => '(14) 98816-6922',
        ];
        $this->json('POST', route('auth.register'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User created successfully.',
            ]);
    }

    public function test_api_auth_register_fails_email_already_exists()
    {
        $user = User::factory()->create();
        $userData = [
            'email' => $user->email,
            'password' => '123456',
            'password_confirmation' => '123456',
            'name' => 'Jane Doe',
            'cellphoneNumber' => '(14) 98816-6922',
        ];
        $this->json('POST', route('auth.register'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.',
                'errors' => [
                    'email' => [
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }

    public function test_api_auth_register_fails_missing_fields()
    {
        $userData = [
            'email' => time() . rand(0, 999) . 'email@email.com',
        ];
        $this->json('POST', route('auth.register'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.',
            ]);
    }

    public function test_api_auth_register_fails_wrong_phone_format_and_wrong_email_format()
    {
        $userData = [
            'email' => time() . rand(0, 999) . 'email.com',
            'cellphoneNumber' => '11111111111'
        ];
        $this->json('POST', route('auth.register'), $userData, [
            'Accept' => 'application/json',
        ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.',
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.'
                    ],
                    'cellphoneNumber' => [
                        'The cellphone number format is invalid.',
                    ]
                ]
            ]);
    }
}
