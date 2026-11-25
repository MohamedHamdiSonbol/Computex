<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get preparation before validation => rules()
     * should return Void
     */
//    public function prepareForValidation(){
//        if (!$this->has('is_active') || $this->input('is_active') !== 1) {
//            $this->merge(['is_active' => 0]);
//        }
//    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('color')?->id;
//        dd($id);
        return [

            'color'       => ['required','array', 'min:1'],

            'color.name'  => [
                                'required',
                                'string',
                                'max:50',
                                Rule::unique('colors', 'name')->ignore($id, 'id'),
            ],

            'color.is_active'    => ['in:0,1'],
        ];
    }

public function passedValidation(): array{
    $color = [
        'name' => $this->input('color.name'),
        'is_active' => $this->input('color.is_active')?? 0,
    ];
    return  $color;
}

    public function messages(): array
    {
        return [
          'required' => 'هذا الحقل مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'language.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'in' => 'القيم المدخلة غير صحيحة',
//          'category_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل', // Custom unique message
          'category_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل', // Custom unique message
        ];
    }

}
