<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code'         => ['required', 'string', 'unique:coupons,code'],
            'discount'     => ['required', 'numeric', 'min:0'],
            'type'         => ['required', 'in:fixed,percentage'],
            'valid_from'   => ['required', 'date'],
            'valid_until'  => ['required', 'date', 'after:valid_from'],
            'is_active'    => ['required', 'in:0,1'],
        ];
    }
    public function messages(): array
    {
        return [
            'code.required'         => 'Coupon code is required.',
            'code.string'           => 'Coupon code must be a valid string.',
            'code.unique'           => 'This coupon code already exists.',

            'discount.required'     => 'Discount value is required.',
            'discount.numeric'      => 'Discount must be a number.',
            'discount.min'          => 'Discount must be at least 0.',

            'type.required'         => 'Coupon type is required.',
            'type.in'               => 'Coupon type must be either fixed or percentage.',

            'valid_from.required'   => 'Start date is required.',
            'valid_from.date'       => 'Start date must be a valid date.',

            'valid_until.required'  => 'End date is required.',
            'valid_until.date'      => 'End date must be a valid date.',
            'valid_until.after'     => 'End date must be after the start date.',

            'is_active.required'    => 'Active status is required.',
            'is_active.in'          => 'Active status must be 0 (inactive) or 1 (active).',
        ];
    }
}
