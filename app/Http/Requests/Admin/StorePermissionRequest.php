<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
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
//        dd(count($this->input('permission')));

        $id = $this->route('permission')?->id;
//        dd($id);
        return [
            'permission' => ['required','array', 'min:1'],

//            'regex:/^01[0125][0-9]{8}$/'
            'permission.*.display_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z][a-z]+(?:\s[A-Z][a-z]+)+$/',
                Rule::unique('permissions', 'display_name')->ignore($id, 'id'),
            ],

        ];
    }

public function passedValidation(): array{
        $permission = $this->input('permission');
        if(count($permission) == 1){
            $permission[0]['name'] = Str::slug($permission[0]['display_name']);
            return $permission;
        }
        else{
            $timestamp = now();
            $permissions = collect($this->input('permission'))->map(function ($item) use ($timestamp) {
                return [
                    'display_name' => $item['display_name'],
                    'name'         => Str::slug($item['display_name']),
                    'created_at'   => $timestamp,
                    'updated_at'   => $timestamp,
                ];
            })->toArray();

            return $permissions;
        }

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
