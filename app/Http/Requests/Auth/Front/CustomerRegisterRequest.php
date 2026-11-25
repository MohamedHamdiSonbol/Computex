<?php

namespace App\Http\Requests\Auth\Front;

use App\Models\Customer;
use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer'   => ['required', 'array', 'min:1'],
            'profile'    => ['required', 'array', 'min:1'],
            'customer.first_name' => ['required', 'string', 'max:255'],
            'customer.last_name'  => ['required', 'string', 'max:255'],
            'customer.email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:customers,email'],
            'customer.password'   => ['required', 'confirmed',  'min:8', Password::defaults()],
            'profile.mobile'     => ['required', 'regex:/^01[0125][0-9]{8}$/', 'unique:profiles,mobile'],
            'profile.gover_id' => ['required', 'integer', 'exists:governorates,id'],
            'profile.city_id'  => ['required', 'integer', 'exists:cities,id'],
            'profile.address'    => ['required', 'string', 'max:255'],
        ];
    }

    public function passedValidation(): array{

        $customerData = [
            'first_name' =>  $this->input('customer.first_name'),
            'last_name' =>  $this->input('customer.last_name'),
            'email' =>  $this->input('customer.email'),
            'password' =>  Hash::make($this->input('customer.password')),
        ];

        $profileData = [
            'mobile' =>  $this->input('profile.mobile'),
            'address' =>  $this->input('profile.address'),
            'governorate_id' =>  $this->input('profile.gover_id'),
            'city_id' =>  $this->input('profile.city_id'),
        ];

        return  [$customerData, $profileData];
    }

    public function messages(): array
    {
        return [
            'customer.password.required' => 'هذا الحقل مطلوب',
            'customer.password.confirmed' => 'كلمتا المرور غير متطابقتين',
            'profile.mobile.required' => 'هذا الحقل مطلوب',
            'mobile.regex' => "Please enter a valid 11-digit Egyptian mobile number starting with 01",
            'mobile.unique' => 'should bu unique',
            'profile.gover_id.required' => 'هذا الحقل مطلوب',
            'profile.city_id.required' => 'هذا الحقل مطلوب',
            'profile.address.required' => 'هذا الحقل مطلوب',
        ];
    }
}
