<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstAddressLine' => 'required|string',
            'secondAddressLine' => 'sometimes|string',
            'postalCode' => 'required|string|regex:/^([\d]{2})\.?([\d]{3})\-?([\d]{3})/',
            'city' => 'required|string',
            'stateId' => 'required|exists:addresses_states,id',
        ];
    }
}
