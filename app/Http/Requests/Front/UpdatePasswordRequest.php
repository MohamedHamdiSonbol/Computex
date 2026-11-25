<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'], // Built-in Laravel rule
            'password' => [
                'required',
                'confirmed',
                'min:8',
                Password::defaults()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'كلمة المرور الحالية غير صحيحة', // Specific rule error
            'password.required' => 'هذا الحقل مطلوب',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين',
            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل',
        ];
    }

}
