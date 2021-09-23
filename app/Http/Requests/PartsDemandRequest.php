<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartsDemandRequest extends FormRequest
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
            'addressId' => 'required|exists:users_addresses,id',
            'partDescription' => 'required|string|min:30|max:6000',
            'demand_status' => 'sometimes|in:OPEN,FINISHED'
        ];
    }
}
