<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignUserRoleRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required','regex:/^[A-Za-z\s_-]+$/', 'exists:roles,name'],
        ];
    }
    public function message(): array
    {
        return [

            'user_id.required' => 'User id field must be required',
            'user_id.integer' => 'User id field value must be integer',
            'user_id.exists' => 'Selected user id does not exist',

            'role_id.required' => 'Role id field must be required',
            'role.regex' => 'The role name may only contain letters, spaces, hyphens, and underscores.',
            'role.exists' => 'The selected role does not exist in the system.',

        ];
    }
}
