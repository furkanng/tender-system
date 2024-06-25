<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            "name" => "required",
            'email' => 'required|unique:App\Models\User,email',
            'phone' => 'required|unique:App\Models\User,phone',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.unique' => 'Bu e-posta zaten kayıtlı.',
            'phone.unique' => 'Bu telefon zaten kayıtlı.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.confirmed' => 'Şifreler birbiriyle uyuşmuyor.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
        ];
    }
}
