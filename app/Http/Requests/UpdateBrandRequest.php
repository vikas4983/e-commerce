<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'regex:/^[A-Za-z\s]+$/', Rule::unique('brands', 'name')->ignore($this->route('brand'))],
            'is_active' => ['required', 'in:1,0',],
        ];
    }

    public function message(): array
    {
        return [
            'name.required' => 'Brand name is required',
            'name.regex' => 'Brand name must be include latters and space only',
            'name.max' => 'Brand name should not exceed 255 characters.',
            'name.unique' => 'The brand name must be unique and not duplicated.',

            'is_active.required' => 'Brand name status is required',
            'is_active.in' => 'Brand status must be either 0 (inactive) or 1 (active)',
        ];
    }
}
