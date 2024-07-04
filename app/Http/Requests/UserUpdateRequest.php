<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $rules = [
            "city" => "required|sometimes",
            "address" => "required|sometimes",
            "district" => "required|sometimes",
            "phone" => "required|sometimes",
            "email" => "required|email|sometimes",
            "name" => "required|sometimes",
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre doğrulaması eşleşmiyor.',
            'city.required' => 'Şehir alanı zorunludur.',
            'address.required' => 'Adres alanı zorunludur.',
            'district.required' => 'İlçe alanı zorunludur.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'E-posta geçerli bir e-posta adresi olmalıdır.',
            'name.required' => 'İsim alanı zorunludur.',
        ];
    }
}
