<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderStatusLogRequest extends FormRequest
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
            'order_id' => ['required', 'exists:orders,id'],
            'status_id'   => ['required', 'exists:statuses,id'],
            'note' => ['nullable', 'string', 'regex:/^[A-Za-z\s]+$/'],
            'is_active' => ['required', 'in:0,1'],
        ];
    }
    public function messages()
    {
        return [
            'order_id.required' => 'Order ID is required.',
            'order_id.exists'   => 'The selected order does not exist.',
            'status_id.required'   => 'Status is required.',
            'status_id.exists'     => 'The selected status does not exist.',
            'note.regex' => 'Note may only contain letters and spaces.',
            'is_active.required' => 'Activation status is required.',
            'is_active.in'       => 'Activation status must be 0 (inactive) or 1 (active).',
        ];
    }
}
