<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRolePermissionRequest extends FormRequest
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
            'role_id' => ['required', 'array'],
            'role_id.*' => ['required', 'integer', 'exists:roles,id'],

            'permission_id' => ['required', 'array'],
            'permission_id.*' => ['required', 'integer', 'exists:permissions,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'role_id.required'        => 'Role ID is required.',
            'role_id.array'           => 'Role ID must be an array.',
            'role_id.*.required'      => 'Each role ID is required.',
            'role_id.*.integer'       => 'Each role ID must be an integer.',
            'role_id.*.exists'        => 'One or more selected roles do not exist.',

            'permission_id.required'  => 'Permission ID is required.',
            'permission_id.array'     => 'Permission ID must be an array.',
            'permission_id.*.required' => 'Each permission ID is required.',
            'permission_id.*.integer' => 'Each permission ID must be an integer.',
            'permission_id.*.exists'  => 'One or more selected permissions do not exist.',
        ];
    }
}
