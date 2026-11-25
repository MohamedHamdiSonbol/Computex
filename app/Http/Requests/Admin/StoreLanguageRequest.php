<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLanguageRequest extends FormRequest
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
        $id = $this->language?->id;
//        dd($id);
        return [
            'abbr' => [
                'required',
                'string',
                'max:10',
                // Table: languages, Column: abbr, Ignore ID: $id
                Rule::unique('languages', 'abbr')->ignore($id),
            ],
            'local' => [
                'required',
                'string',
                'max:20',
                Rule::unique('languages', 'local')->ignore($id),
            ],
            'name'      => ['required', 'string', 'max:100'],
            'direction' => ['required', 'in:rtl,ltr'],
            'active'    => [ 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
          'required' => 'هذا الحقل مطلوب',
          'name.string' => 'اسم اللغة لابد ان يكون أحرف',
          'abbr.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'in' => 'القيم المدخلة غير صحيحة',
          'abbr.unique'  => 'هذا الاختصار مستخدم من قبل', // Custom unique message
          'local.unique' => 'هذا المسار المحلي مستخدم من قبل', // Custom unique message
        ];
    }

}
