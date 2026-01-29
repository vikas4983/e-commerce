<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s\-]+$/', 'max:255', 'unique:statuses,name'],
            'is_active' => ['required', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.regex' => 'Name may only contain letters, spaces, and hyphens.',
            'name.max' => 'Name should not exceed 255 characters.',
            'name.unique' => 'This name already exists in the system.',

            'is_active.in' => 'is_active must be either 0 (inactive) or 1 (active).',
        ];
    }
}
