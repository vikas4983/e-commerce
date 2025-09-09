<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('role');
        return [
            'name' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s]+$/',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'guard_name' => [
                'required',
                'string',
                'regex:/^[A-Za-z\s]+$/',
                'max:255',

            ],
        ];
    }

    public function messages(): array
    {
        return (new StoreRoleRequest())->messages();
    }
}
