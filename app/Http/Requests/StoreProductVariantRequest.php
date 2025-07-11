<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
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
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'attribute'  => ['required', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'value'      => ['required', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'price'      => ['required', 'numeric', 'min:0'],
            'stock'      => ['required', 'integer', 'min:0'],
            'is_active'  => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.integer'  => 'Product ID must be an integer.',
            'product_id.exists'   => 'Selected product does not exist.',

            'attribute.required'  => 'Attribute name is required.',
            'attribute.regex'     => 'Attribute must contain only letters and spaces.',
            'attribute.max'       => 'Attribute may not be greater than 255 characters.',

            'value.required'      => 'Value is required.',
            'value.regex'         => 'Value must contain only letters and spaces.',
            'value.max'           => 'Value may not be greater than 255 characters.',

            'price.required'      => 'Price is required.',
            'price.numeric'       => 'Price must be a number.',
            'price.min'           => 'Price must be at least 0.',

            'stock.required'      => 'Stock quantity is required.',
            'stock.integer'       => 'Stock must be an integer.',
            'stock.min'           => 'Stock cannot be negative.',

            'is_active.required'  => 'Active status is required.',
            'is_active.in'        => 'Active status must be either 0 or 1.',
        ];
    }
}
