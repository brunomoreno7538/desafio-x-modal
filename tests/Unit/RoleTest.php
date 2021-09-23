<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_admins_can_see_all_roles()
    {
        $user = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $this->actingAs($user, 'api')
            ->get(route('administrators.roles.index'), [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_admins_can_create_role()
    {
        $user = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $roleData = [
            'description' => 'TEST_ROLE'
        ];
        $this->actingAs($user, 'api')
            ->post(route('administrators.roles.store'), $roleData, [
                'Accept' => 'application/json'
            ])->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_admins_can_update_role()
    {
        $user = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $role = Role::factory()->create();
        $roleNewData = [
            'description' => 'TEST_ROLE'
        ];
        $this->actingAs($user, 'api')
            ->put(route('administrators.roles.update', ['id' => $role->id]), $roleNewData, [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_admins_can_delete_role()
    {
        $user = User::factory()->create();
        $user->assignRole('ADMINISTRATOR');
        $role = Role::factory()->create();
        $this->actingAs($user, 'api')
            ->delete(route('administrators.roles.delete', ['id' => $role->id]), [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_administrator_middleware_in_roles_routes()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api')
            ->call('GET', route('administrators.roles.index'))
            ->assertStatus(403);
    }
}
