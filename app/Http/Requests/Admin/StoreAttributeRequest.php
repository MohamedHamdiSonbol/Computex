<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        // 1. Get the current attribute array (or empty array if missing)
        $attribute = $this->input('attribute', []);

        // 2. Explicitly set the active key if it doesn't exist
        if (!isset($attribute['active'])) {
            $attribute['active'] = 0;
        }

        // 3. Merge the updated array back
        $this->merge(['attribute' => $attribute]);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('attribute')?->id;
//        dd($id);
        return [
            'attribute_translations' => ['required','array', 'min:1'],

            'attribute' => ['array', 'min:1'],

            'attribute_translations.*.name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('attribute_translations', 'name')->ignore($id, 'attribute_id'),
            ],

            'product_translations.*.language_id' => [
                'required',
                'integer',
                'exists:languages,id',
            ],

            'attribute.active'    => ['in:0,1'],
        ];
    }

public function passedValidation(): array{
//return request()->all();
    $attribute = ['active' => $this->attribute['active']];
    $productTranslations = collect($this->attribute_translations);
    return  [$attribute, $productTranslations];
}

    public function messages(): array
    {
        return [
          'required' => 'هذا الحقل مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'language.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'attribute.active' => 'wrong thing',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'in' => 'القيم المدخلة غير صحيحة',
          'product_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل',
          'integer'  => 'لابد ان يكون رقم',
        ];
    }

}
