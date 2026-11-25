<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
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

        $id = $this->route('brand')?->id;
//        dd($id);
        return [
            'brand_translations'               => ['required','array', 'min:1'],

            'brand'                            => ['required','array', 'min:1'],

            'brand_translations.*.language_id' => [
                                                      'required',
                                                      'integer',
                                                      'exists:languages,id',
            ],

            'brand_translations.*.name'        => [
                                                      'required',
                                                      'string',
                                                      'max:50',
                                                      Rule::unique('brand_translations', 'name')->ignore($id, 'brand_id'),
            ],

            'brand.logo'                       => ['nullable', 'mimes:jpg,jpeg,png,webp,avif', 'max:3000'],

            'brand.is_active'                  => ['in:0,1'],

        ];
    }

public function passedValidation(): array{
    $brand = $this->input('brand');

    if($this->has('brand.logo') && $this->brand['logo']) {
        $brand['logo'] = upload_image($this->brand['logo']);  // Image name
        $newPhoto = $this->brand['logo'];                       // Physical image
    }

    $translationData = request('brand_translations');

    return  [$brand, $translationData, $newPhoto?? ""];
}


    public function messages(): array
    {
        return [
//          'required' => 'هذا الحقل مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'language.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'brand_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل', // Custom unique message
        ];
    }

}
