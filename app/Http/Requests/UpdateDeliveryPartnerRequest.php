<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeliveryPartnerRequest extends FormRequest
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
                'sometimes',
                'required',
                'string',
                Rule::unique('delivery_partners', 'name')->ignore($this->route('deliveryPartner')),
                'regex:/^[A-Za-z\s]+$/',
                'max:50',
            ],
            'contact_number' => [
                 'sometimes',
                'required',
                Rule::unique('delivery_partners', 'contact_number')->ignore($this->route('deliveryPartner')),
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
        return (new StoreDeliveryPartnerRequest)->messages();
    }
}
