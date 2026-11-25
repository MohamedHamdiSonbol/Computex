<?php

namespace App\Http\Requests\Admin;

use App\Models\Customer;
use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreAdminRequest extends FormRequest
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
        $id = $this->route('admin')?->id;
//        dd($id);
//        dd(
//            $this->route('admin'), // Is this null or an Admin model?
//            $this->route('admin')?->profile?->id // Is this null or an integer?
//        );

        $rule = Rule::requiredIf(! $this->isMethod('PATCH') && ! $this->isMethod('PUT'));
        return [
            'admin'   => ['required', 'array', 'min:1'],
            'profile'    => ['required', 'array', 'min:1'],
            'admin.name' => ['required', 'string', 'max:255'],
            'admin.email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:customers,email'],
            'admin.password'   => [$rule, 'confirmed',  'min:8', Password::defaults()],
            'admin.role_id'    => ['required', 'integer', 'exists:roles,id'],
            'profile.mobile'     => ['required', 'regex:/^01[0125][0-9]{8}$/', Rule::unique('profiles', 'mobile')->where('profileable_type', 'admin')->ignore($id, 'profileable_id')],
            'profile.gover_id' => ['required', 'integer', 'exists:governorates,id'],
            'profile.city_id'  => ['required', 'integer', 'exists:cities,id'],
            'profile.address'    => ['required', 'string', 'max:255'],
        ];
    }

    public function passedValidation(): array{

        $adminData = [
            'name' =>  $this->input('admin.name'),
            'email' =>  $this->input('admin.email'),
            'role_id' =>  $this->input('admin.role_id'),
        ];

        // Only hash and inject the password if it's filled in the request
        if ($this->filled('admin.password')) {
            $adminData['password'] = Hash::make($this->input('admin.password'));
        }

        $profileData = [
            'mobile' =>  $this->input('profile.mobile'),
            'address' =>  $this->input('profile.address'),
            'governorate_id' =>  $this->input('profile.gover_id'),
            'city_id' =>  $this->input('profile.city_id'),
        ];


        return  [$adminData, $profileData];
    }

    public function messages(): array
    {
        return [
            'admin.password.required' => 'هذا الحقل مطلوب',
            'admin.password.confirmed' => 'كلمتا المرور غير متطابقتين',
            'profile.mobile.required' => 'هذا الحقل مطلوب',
            'mobile.regex' => "Please enter a valid 11-digit Egyptian mobile number starting with 01",
            'mobile.unique' => 'should bu unique',
            'profile.gover_id.required' => 'هذا الحقل مطلوب',
            'profile.city_id.required' => 'هذا الحقل مطلوب',
            'profile.address.required' => 'هذا الحقل مطلوب',
        ];
    }
}
