<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'country' => 'required|string',
            'name' => 'required|string|min:3',
            'company_name' => 'nullable',
            'address' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'zip_code' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'note' => 'nullable',
        ];
    }

    public function messages(): array
    {
        //@todo x.string validasyon response'ları eklenmeli
        return [
            'country.required' => __('country alanı zorunludur'),
            'name.required' => __('name alanı zorunludur'),
            'name.min' => __('İsim alanı en az 3 karakterden oluşmalıdır.'),
            'address.required' => __('address alanı zorunludur'),
            'city.required' => __('city alanı zorunludur'),
            'district.required' => __('district alanı zorunludur'),
            'email.required' => __('email alanı zorunludur'),
            'email.email' => __('Geçerli bir e-posta adresi girilmelidir'),
            'zip_code.required' => __('zip_code alanı zorunludur'),
            'phone.required' => __('phone alanı zorunludur'),
        ];
    }
}
