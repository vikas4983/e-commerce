<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusLogRequest extends FormRequest
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
            'status_id'   => ['sometimes', 'required', 'exists:statuses,id'],
            'note' => ['nullable', 'string', 'regex:/^[A-Za-z\s]+$/'],
            'is_active' => ['required', 'in:0,1'],

        ];
    }
    public function messages()
    {
        return [
            'status_id.required' => 'Status is required.',
            'status_id.exists'     => 'The selected status does not exist.',
            'note.string'        => 'Note must be a valid string.',
            'note.regex'         => 'Note may only contain letters and spaces.',
            'is_active.required' => 'Activation status is required.',
            'is_active.in'       => 'Activation status must be 0 (inactive) or 1 (active).',
        ];
    }
}
