<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('role')?->id;
//        dd($id);
        return [
            'role.display_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z][a-z]+(?:\s[A-Z][a-z]+)+$/',
                Rule::unique('roles', 'display_name')->ignore($id, 'id'),
            ],

            'permission.permission_id'   => ['required','array'],
            'permission.permission_id.*' => ['exists:permissions,id'],
        ];
    }

public function passedValidation(): array{
    $role = [
        'display_name' =>   request()->input('role.display_name'),
        'name'         =>   Str::slug(request()->input('role.display_name'))
    ] ;

    $permissionIds = request()->input('permission.permission_id');

    return [$role, $permissionIds];
}

    public function messages(): array
    {
        return [
          'required' => 'هذا الحقل مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'max' => 'اسم اللغة لابد الا يزيد عن 50 حرف',
        ];
    }

}
