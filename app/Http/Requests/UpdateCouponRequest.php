<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
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
        $couponId = $this->route('coupon');
        return [
            'code'         => ['required', 'string', Rule::unique('coupons', 'code')->ignore($couponId)],
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
            'code.string'           => 'Coupon code must be a valid string.',
            'code.unique'           => 'This coupon code already exists.',

            'discount.numeric'      => 'Discount must be a number.',
            'discount.min'          => 'Discount must be at least 0.',

            'type.in'               => 'Coupon type must be either fixed or percentage.',

            'valid_from.date'       => 'Start date must be a valid date.',
            'valid_until.date'      => 'End date must be a valid date.',
            'valid_until.after'     => 'End date must be after the start date.',

            'is_active.in'          => 'Active status must be 0 (inactive) or 1 (active).',
        ];
    }
}
