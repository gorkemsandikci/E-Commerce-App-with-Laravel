<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentFormRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'email' => 'nullable|email',
            'phone' => 'required',
            'message' => 'required',
            'subject' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı zorunludur',
            'name.string' => 'İsim alanı harflerden oluşmalıdır',
            'name.min' => 'İsim alanı Minimum 3 karakterden oluşmalı',
            'email.email' => 'E-posta alanı geçersiz',
            'phone' => 'Telefon numarası girilmeli',
            'message' => 'Mesaj alanı boş bırakılamaz',
            'subject' => 'Konu alanı boş bırakılamaz'
        ];
    }
}
