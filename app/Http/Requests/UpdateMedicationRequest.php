<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest as BaseRequest;
use App\Models\Medication;
use Illuminate\Validation\Rule;

class UpdateMedicationRequest extends BaseRequest
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
            'name' => 'max:100',
            'quantity' => 'required|numeric',
            'status' => Rule::in([Medication::ACTIVE_STATUS, Medication::INACTIVE_STATUS])
        ];
    }
}
