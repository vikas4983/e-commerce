<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeliveryPartnerRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'unique:delivery_partners,name',
                'regex:/^[A-Za-z\s]+$/',
                'max:50',
            ],
            'contact_number' => [
                'required',
                'unique:delivery_partners,contact_number',
                'digits_between:10,12',
            ],
            'is_active' => [
                'required',
                'in:0,1',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The delivery partner name field is required.',
            'name.unique' => 'This delivery partner name is already taken.',
            'name.string' => 'The delivery partner name must be a string.',
            'name.regex' => 'The delivery partner name can only contain letters and spaces.',
            'name.max' => 'The delivery partner name must not be greater than 50 characters.',

            'contact_number.required' => 'The contact number field is required.',
            'contact_number.unique' => 'This contact number is already in use.',
            'contact_number.digits_between' => 'The contact number must be between 10 and 12 digits.',

            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either 0 (inactive) or 1 (active).',
        ];
    }
}
