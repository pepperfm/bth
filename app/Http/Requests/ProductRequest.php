<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('products')->ignore($this->id),
            ],
            'name' => ['required', 'string', 'min:10', 'max:255'],
            'status' => ['required', Rule::enum(\App\Enums\StatusEnum::class)],
            'options' => ['required', 'array'],
            'options.color_name' => ['required', 'string', 'max:255'],
            'options.color_value' => ['required', 'string', 'max:255', 'hex_color'],
        ];
    }
}
