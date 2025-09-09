<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:255', 'unique:roles,name',],
            'guard_name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:255'],

        ];
    }
    public function message(): array
    {
        return [
            'name.required' => 'Name field is required.',
            'name.string' => 'Name must be a valid string.',
            'name.regex' => 'Name should contain only letters and spaces.',
            'name.max' => 'Name may not be greater than 255 characters.',
            'name.unique' => 'This role name already exists.',

            'guard_name.required' => 'Guard name field is required.',
            'guard_name.string' => 'Guard name must be a valid string.',
            'guard_name.regex' => 'Guard name should contain only letters and spaces.',
            'guard_name.max' => 'Guard name may not be greater than 255 characters.',
        ];
    }
}
