<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer',],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'is_active' => ['required', 'in:0,1'],
        ];
    }

    public function message(): array
    {
        return [
            'category_id.required' => 'Category ID is required.',
            'category_id.integer' => 'Category ID must be an integer.',

            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must contain letters and spaces.',
            'name.max' => 'Product name must not be greater than 255 characters.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',

            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be an integer.',
            
            'description.required' => 'Product description is required.',
            'description.string' => 'Product description must be a string.',


            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, jpg, png.',
            'image.max' => 'Image size must not exceed 2MB.',

            'is_active.required' => 'Product Status is required.',

        ];
    }
}
