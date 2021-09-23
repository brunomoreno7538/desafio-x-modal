<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactInformationResource extends JsonResource
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
            'contactInformationDetails' => [
                'cellphoneNumber' => $this->cellphone_number,
                'phoneNumber' => $this->phone_number,
                'extraEmail' => $this->extra_email
            ],
        ];
    }
}
