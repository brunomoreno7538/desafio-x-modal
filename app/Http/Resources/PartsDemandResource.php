<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartsDemandResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'demandDetails' => [
                'partDescription' => $this->part_description,
                'status' => $this->demand_status,
                'userDetails' => [
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'contactInfoDetails' => [
                        'cellphoneNumber' => $this->user->contactInformation->cellphone_number,
                        'phoneNumber' => $this->user->contactInformation->phone_number,
                        'extraEmail' => $this->user->contactInformation->extra_email
                    ],
                    'addressDetails' => [
                        'firstAddressLine' => $this->address->address_line_1,
                        'secondAddressLine' => $this->address->address_line_2,
                        'postalCode' => $this->address->postal_code,
                        'city' => $this->address->city,
                        'state' =>[
                            'code' => $this->address->state->code,
                            'name' => $this->address->state->name
                        ]
                    ]
                ]
            ]
        ];
    }
}
