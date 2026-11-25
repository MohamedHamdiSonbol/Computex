<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
//    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('category')?->id;
//        dd($id);
        return [
            'category_translations' => ['required','array', 'min:1'],

            'category' => ['required','array', 'min:1'],

            'category_translations.*.language_id' => [
                'required',
                'integer',
                'exists:languages,id',
            ],

            'category_translations.*.name' => [
                'required',
                'string',
                'max:100',
                // exclude the update where id == category_id
                Rule::unique('category_translations', 'name')->ignore($id, 'category_id'),
            ],

            'category_translations.*.description' => [
                'required',
                'string',
                'max:100',
            ],

            'category.photo'     => ['nullable', 'mimes:jpg,jpeg,png,webp,avif', 'max:3000'],

            'category.active'    => ['in:0,1'],
        ];
    }

public function passedValidation(): array{

    $category = [
     'active' => $this->category['active']?? 0,
    ];

    if($this->has('category.photo') && $this->category['photo']) {
        $category['photo'] = upload_image($this->category['photo']);  // Image name
        $newPhoto = $this->category['photo'];                       // Physical image
    }

    $categoryTranslations = collect($this->category_translations);

    return  [$category, $categoryTranslations, $newPhoto?? ""];
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
