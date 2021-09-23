<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'addressDetails' => [
                'id' => $this->id,
                'user_id' => $this->user->id,
                'firstAddressLine' => $this->address_line_1,
                'secondAddressLine' => $this->address_line_2,
                'postalCode' => $this->postal_code,
                'city' => $this->city,
                'state' => [
                    'code' => $this->state->code,
                    'name' => $this->state->name,
                ]
            ],
        ];
    }
}
