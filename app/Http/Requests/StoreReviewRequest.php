<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'rating'     => ['required', 'integer', 'between:1,5'],
            'comment'    => ['nullable', 'string'],
            'is_active'  => ['required', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'product_id.required' => 'Product is required.',
            'product_id.exists'   => 'The selected product does not exist.',
            'rating.required'     => 'Rating is required.',
            'rating.integer'      => 'Rating must be a number.',
            'rating.between'      => 'Rating must be between 1 and 5.',
            'is_active.required'  => 'Active status is required.',
            'is_active.in'        => 'Active status must be either 0 (inactive) or 1 (active).',
        ];
    }
}
