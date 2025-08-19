<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'is_active' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Category name is required.',
            'name.string'     => 'Category name must be a string.',
            'name.max'        => 'Category name should not exceed 255 characters.',
            'name.unique'     => 'Category name already exists.',

            'is_active.required' => 'The is_active field is required.',
            'is_active.in'       => 'The is_active field must be either 0 (inactive) or 1 (active).',
        ];
    }
}
