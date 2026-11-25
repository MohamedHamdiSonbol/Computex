<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeValueRequest extends FormRequest
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
        $this->merge([
            'attribute_id' => $this->route('attribute')->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $attributeId = $this->route('attribute')?->id;
        $valueId = $this->route('value')?->id;
//        dd($id);
       $rules=  [
            'attribute_value_translations' => ['required','array', 'min:1'],

            'attribute_value_translations.*.value' => [
                'required',
                'string',
                'max:50',
                'distinct',
                Rule::unique('attribute_value_translations', 'value')
                    ->ignore($valueId, 'attribute_value_id')
                    ->where(function ($query) use ($attributeId) {
                        $query->whereIn('attribute_value_id', fn($q) => $q->select('id')->from('attribute_values')->where('attribute_id', $attributeId));
                    }),
            ],

            'attribute_value_translations.*.language_id' => [
                'required',
                'integer',
                'exists:languages,id',
            ],

        ];

        // Only apply these rules on STORE (POST)
        if ($this->isMethod('post')) {
            $rules['attribute_id'] = [
                'required',
                'integer',
                'exists:attributes,id'
            ];
        }

        return $rules;
    }

public function passedValidation(): array {
    $valuesTranslations = collect($this->attribute_value_translations);

    if (request()->isMethod('patch')) {
        return  [$valuesTranslations];
    }

//     detect number of active languages
    $langCount = max(1, count(get_active_languages()));

//     group translations per attribute value
    $valueTranslations = $valuesTranslations->chunk($langCount)->transform(function ($group) {
        return $group->values(); // reset keys, keep objects
    });

    return  [$valueTranslations];
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
          'attribute_id.exist'  => 'لابد ان يكون موجود',
        ];
    }

}
