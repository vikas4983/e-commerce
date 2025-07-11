<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
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
            'product_id'   => ['required', 'exists:products,id'],
            'variant_id'   => ['nullable', 'exists:product_variants,id'],
            'quantity'     => ['required', 'integer', 'min:1'],
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.exists'         => 'The selected user does not exist.',
            'guest_token.uuid'       => 'The guest token must be a valid UUID.',
            'product_id.required'    => 'Product is required.',
            'product_id.exists'      => 'The selected product does not exist.',
            'variant_id.exists'      => 'The selected variant does not exist.',
            'quantity.required'      => 'Quantity is required.',
            'quantity.integer'       => 'Quantity must be an integer.',
            'quantity.min'           => 'Quantity must be at least 1.',
        ];
    }
}
