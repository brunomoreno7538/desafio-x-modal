<?php

namespace Tests\Unit;

use App\Models\Address\Address;
use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_address_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
            'secondAddressLine' => 'Foo Bar',
            'postalCode' => '11111111',
            'city' => 'Foo Bar',
            'stateId' => 1,
        ];
        $this->actingAs($user, 'api')
            ->post(route('users.addresses.store'), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_update_address_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
        ]);
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
            'secondAddressLine' => 'Foo Bar',
            'postalCode' => '11111111',
            'city' => 'Foo Bar',
            'stateId' => 1,
        ];
        $this->actingAs($user, 'api')
            ->put(route('users.addresses.update', ['id' => $address->id]), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_deactive_address_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
        ]);
        $this->actingAs($user, 'api')
            ->delete(route('users.addresses.delete', ['id' => $address->id]), [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_user_update_other_user_address()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $user1 = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
        ]);
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
            'secondAddressLine' => 'Foo Bar',
            'postalCode' => '11111111',
            'city' => 'Foo Bar',
            'stateId' => 1,
        ];
        $this->actingAs($user, 'api')
            ->put(route('users.addresses.update', ['id' => $address->id]), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_user_delete_deactived_address()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
            'active' => false,
        ]);
        $this->actingAs($user, 'api')
            ->delete(route('users.addresses.delete', ['id' => $address->id]), [
                'Accept' => 'application/json'
            ])->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_user_delete_other_user_address()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
            'active' => false,
        ]);
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
            'secondAddressLine' => 'Foo Bar',
            'postalCode' => '11111111',
            'city' => 'Foo Bar',
            'stateId' => 1,
        ];
        $this->actingAs($user, 'api')
            ->put(route('users.addresses.update', ['id' => $address->id]), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_user_create_address_fails_missing_fields()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
        ];
        $this->actingAs($user, 'api')
            ->post(route('users.addresses.store'), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.',
            ]);
    }

    public function test_user_update_address_fails_missing_fields()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'address_line_2' => 'Foo Bar',
            'postal_code' => '11111111',
            'city' => 'Foo Bar',
            'state_id' => 1,
        ]);
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
        ];
        $this->actingAs($user, 'api')
            ->put(route('users.addresses.update', ['id' => $address->id]), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.',
            ]);
    }

    public function test_user_create_address_fails_invalid_state()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $addressData = [
            'firstAddressLine' => 'Foo Bar',
            'secondAddressLine' => 'Foo Bar',
            'postalCode' => '11111111',
            'city' => 'Foo Bar',
            'stateId' => rand(100, 1000),
        ];
        $this->actingAs($user, 'api')
            ->post(route('users.addresses.store'), $addressData, [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.'
            ]);
    }

    public function test_user_index_addresses_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->get(route('users.addresses.index'), [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_non_auth_user_access_address_routes_fails()
    {
        $this->get(route('users.addresses.index'), [
            'Accept' => 'application/json'
        ])->assertStatus(401);
    }
}
