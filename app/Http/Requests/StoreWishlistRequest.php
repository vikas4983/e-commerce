<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'is_active'  => ['required', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'product_id.required' => 'The product field is required.',
            'product_id.exists'   => 'The selected product does not exist.',

            'is_active.required'  => 'The active status is required.',
            'is_active.in'        => 'The active status must be either 0 (inactive) or 1 (active).',
        ];
    }
}
