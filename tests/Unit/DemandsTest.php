<?php

namespace Tests\Unit;

use App\Models\Address\Address;
use App\Models\ContactInformation;
use App\Models\PartsDemand;
use App\Models\User;
use Tests\TestCase;

class DemandsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_index_demands_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->get(route('demands.index'))
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_index_all_demands_admin_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $user1 = User::factory()->create();
        $user1->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user1->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        PartsDemand::factory()->create([
            'user_id' => $user1->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $this->actingAs($user, 'api')
            ->get(route('demands.index'), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'demandsCount' => PartsDemand::all()->count()
            ]);
    }

    public function test_create_demand_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demandData = [
            'addressId' => $address->id,
            'partDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ];
        $this->actingAs($user, 'api')
            ->post(route('demands.store'), $demandData, [
                'Accept' => 'application/json'
            ])->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_create_demand_with_missing_fields_fails()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demandData = [
            'addressId' => $address->id,
        ];
        $this->actingAs($user, 'api')
            ->post(route('demands.store'), $demandData, [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid fields.'
            ]);
    }

    public function test_create_demand_with_another_user_address_fails()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demandData = [
            'addressId' => $address->id,
            'partDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ];
        $this->actingAs($user, 'api')
            ->post(route('demands.store'), $demandData, [
                'Accept' => 'application/json'
            ])->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Address does not belong to user.'
            ]);
    }

    public function test_update_demand_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demandData = [
            'addressId' => $address->id,
            'partDescription' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ];
        $demand = PartsDemand::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $this->actingAs($user, 'api')
            ->put(route('demands.update', ['id' => $demand->id]), $demandData, [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_delete_demand_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demand = PartsDemand::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $this->actingAs($user, 'api')
            ->delete(route('demands.update', ['id' => $demand->id]), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Demand deleted successfully.'
            ]);
    }

    public function test_change_demand_status()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demand = PartsDemand::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $this->actingAs($user, 'api')
            ->patch(route('demands.change_status', ['id' => $demand->id]), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_change_status_on_finished_demand_fails()
    {
        $user = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demand = PartsDemand::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'demand_status' => 'FINISHED',
        ]);
        $this->actingAs($user, 'api')
            ->patch(route('demands.change_status', ['id' => $demand->id]), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Demand is already finished.'
            ]);
    }

    public function test_admin_change_status_on_other_user_demand_successfully()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user1->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demand = PartsDemand::factory()->create([
            'user_id' => $user1->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);
        $this->actingAs($user, 'api')
            ->patch(route('demands.change_status', ['id' => $demand->id]), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_change_status_on_other_user_demand_fails()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $user->assignRole('USER');
        $address = Address::factory()->create([
            'user_id' => $user1->id,
            'address_line_1' => 'Foo Bar',
            'postal_code' => '11111-111',
            'city' => 'Foobar',
            'state_id' => 1,
        ]);
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user1->id,
            'cellphone_number' => '(14) 98816-6922'
        ]);
        $demand = PartsDemand::factory()->create([
            'user_id' => $user1->id,
            'address_id' => $address->id,
            'contact_info_id' => $contactInformation->id,
            'part_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'demand_status' => 'FINISHED',
        ]);
        $this->actingAs($user, 'api')
            ->patch(route('demands.change_status', ['id' => $demand->id]), [
                'Accept' => 'application/json'
            ])
            ->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Demand does not belong to user.'
            ]);
    }
}
