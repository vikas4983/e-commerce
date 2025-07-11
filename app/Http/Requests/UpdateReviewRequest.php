<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'rating'     => ['sometimes', 'integer', 'between:1,5'],
            'comment'    => ['nullable', 'string'],
            'is_active'  => ['sometimes', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'rating.integer'     => 'Rating must be a number.',
            'rating.between'     => 'Rating must be between 1 and 5.',
            'is_active.in'       => 'Active status must be either 0 or 1.',
        ];
    }
}
