<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'user_id'         => ['nullable', 'exists:users,id'],
            'guest_token'     => ['nullable', 'uuid'],
            'total_amount'    => ['required', 'numeric', 'min:0'],
            'payment_status'  => ['nullable', 'string','exists:statuses,id'],
            'payment_method'  => ['nullable', 'string', 'max:50'],
            'order_status'    => ['required', 'string','exists:statuses,id'],
            'is_active'       => ['nullable', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.exists'         => 'The selected user does not exist.',
            'guest_token.uuid'       => 'The guest token must be a valid UUID.',
            'total_amount.required'  => 'Total amount is required.',
            'total_amount.numeric'   => 'Total amount must be a number.',
            'total_amount.min'       => 'Total amount must be at least 0.',
            'payment_method.max'     => 'Payment method may not be greater than 50 characters.',
            'is_active.in'           => 'Is active must be either 0 or 1.',
        ];
    }
}
