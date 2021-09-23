<?php

namespace Tests\Unit;

use App\Models\ContactInformation;
use App\Models\User;
use Tests\TestCase;

class ContactInformationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_update_contact_information_successfully()
    {
        $user = User::factory()->create();
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922',
            'phone_number' => '(14) 98816-6922',
            'extra_email' => 'foo@bar.com',
        ]);
        $contactInformationData = [
            'cellphoneNumber' => '(14) 98816-6922',
            'phoneNumber' => '(14) 98816-6922',
            'extraEmail' => 'foo@bar.com'
        ];
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->put(route('users.contact-information.update', ['id' => $contactInformation->id]), $contactInformationData,  [
                'Accept' => 'application/json'
            ])->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_user_update_contact_information_missing_fields_fails()
    {
        $user = User::factory()->create();
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922',
            'phone_number' => '(14) 98816-6922',
            'extra_email' => 'foo@bar.com',
        ]);
        $contactInformationData = [
            'phoneNumber' => '(14) 98816-6922',
            'extraEmail' => 'foo@bar.com'
        ];
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->put(route('users.contact-information.update', ['id' => $contactInformation->id]), $contactInformationData,  [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_user_update_other_user_contact_information_fails()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user1->id,
            'cellphone_number' => '(14) 98816-6922',
            'phone_number' => '(14) 98816-6922',
            'extra_email' => 'foo@bar.com',
        ]);
        $contactInformationData = [
            'cellphoneNumber' => '(14) 98816-6922',
        ];
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->put(route('users.contact-information.update', ['id' => $contactInformation->id]), $contactInformationData,  [
                'Accept' => 'application/json'
            ])->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Contact information does not belong to user.'
            ]);
    }

    public function test_user_update_contact_information_with_invalid_fields()
    {
        $user = User::factory()->create();
        $contactInformation = ContactInformation::factory()->create([
            'user_id' => $user->id,
            'cellphone_number' => '(14) 98816-6922',
            'phone_number' => '(14) 98816-6922',
            'extra_email' => 'foo@bar.com',
        ]);
        $contactInformationData = [
            'cellphoneNumber' => '123456789',
            'phoneNumber' => '123456789',
            'extraEmail' => 'test_incorrect_email.com'
        ];
        $user->assignRole('USER');
        $this->actingAs($user, 'api')
            ->put(route('users.contact-information.update', ['id' => $contactInformation->id]), $contactInformationData,  [
                'Accept' => 'application/json'
            ])->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }
}
