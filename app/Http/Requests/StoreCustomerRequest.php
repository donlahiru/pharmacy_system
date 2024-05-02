<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest as BaseRequest;

class StoreCustomerRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'max:100',
            'street_address' => 'max:100',
            'city' => 'max:50',
            'postal_code' => 'max:10',
            'phone_no' => 'digits:10|unique:customers,phone_no'
        ];
    }
}
