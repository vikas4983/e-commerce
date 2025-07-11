<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'user_id'      => ['nullable', 'exists:users,id'],
            'guest_token'  => ['nullable', 'uuid'],
            'type'         => ['required', 'in:shipping,billing'],
            'full_name'    => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'address_line' => ['required', 'string', 'regex:/^[A-Za-z0-9\s,\.-]+$/', 'max:255'],
            'mobile'       => ['required', 'string', 'regex:/^[0-9]{10,12}$/'],
            'postal_code'  => ['required', 'string', 'regex:/^[0-9]{4,20}$/'],
            'country'      => ['nullable', 'integer'],
            'state'        => ['required', 'integer'],
            'city'         => ['required', 'integer'],

        ];
    }
    public function messages(): array
    {
        return [
            'user_id.exists'        => 'The selected user ID is invalid.',

            'guest_token.uuid'      => 'The guest token must be a valid UUID.',

            'type.required'         => 'The address type is required.',
            'type.in'               => 'The type must be either shipping or billing.',

            'full_name.required'    => 'Full name is required.',
            'full_name.string'      => 'Full name must be a valid string.',
            'full_name.regex'       => 'Full name must contain only letters and spaces (no special characters).',

            'mobile.required'       => 'Mobile number is required.',
            'mobile.string'         => 'Mobile number must be a string.',
            'mobile.regex'          => 'Mobile must be a 10 to 12 digit number.',

            'address_line.required' => 'Address line is required.',
            'address_line.string'   => 'Address line must be a valid string.',
            'address_line.regex'    => 'Address can contain only letters, numbers, spaces, commas, periods, and hyphens.',

            'postal_code.required'  => 'Postal code is required.',
            'postal_code.string'    => 'Postal code must be a string.',
            'postal_code.regex'     => 'Postal code must be 4 to 20 digits.',

            'country.integer'       => 'Country must be a valid numeric ID.',

            'state.required'        => 'State is required.',
            'state.integer'         => 'State must be a valid numeric ID.',

            'city.required'         => 'City is required.',
            'city.integer'          => 'City must be a valid numeric ID.',
        ];
    }
}
