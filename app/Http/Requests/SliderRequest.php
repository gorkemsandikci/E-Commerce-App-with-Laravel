<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'description' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Başlık alanı zorunludur',
            'name.min' => 'Başlık alanı Minimum 3 karakterden oluşmalı',
            'description.required' => 'İçerik alanı zorunludur',
        ];
    }
}
