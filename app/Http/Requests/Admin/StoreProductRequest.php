<?php

namespace App\Http\Requests\Admin;

use App\Rules\MatchColorQuantities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
//        return $this->all();
//    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
//dd(request()->all());
        $id = $this->route('product')?->id;
//        dd($id);
//        $totalQuantity = $this->input('product.quantity');
//        $colorsQuantity = collect($this->input('colors'))->sum('quantity');
//        dd($totalQuantity, $colorsQuantity);

        return [
            'product_translations' => ['required','array', 'min:1'],

            'product' => ['required','array', 'min:1'],

            'colors' => ['required','array', 'min:1'],

            'product_translations.*.name' => [
                'required',
                'string',
                'max:100',
                // exclude the update where id == product_id
                Rule::unique('product_translations', 'name')->ignore($id, 'product_id'),
            ],

            'product_translations.*.description' => [
                'required',
                'string',
                'max:3000',
            ],

            'product_translations.*.language_id' => [
                'required',
                'integer',
                'exists:languages,id',
            ],

            'product.category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'product.brand_id' => [
                'required',
                'integer',
                'exists:brands,id',
            ],

            'product.photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:3000'],

            'product.quantity'   => ['required', 'integer', 'min:1', new MatchColorQuantities],

            'product.price'    => ['required', 'numeric', 'decimal:0,2', 'min:1'],

            'colors.*.color_id' => ['required', 'distinct', 'integer', 'exists:colors,id',
                Rule::unique('product_color', 'color_id')
                    ->where('product_id', $id)
                    ->ignore($id, 'product_id')],

            'colors.*.quantity' => ['required', 'integer', 'min:0'],

            'product.active'    => ['in:0,1'],

            'attributes' => ['nullable', 'array', 'min:1'],

            'attributes.*' => ['distinct', 'integer', 'exists:attributes,id'],

            'attribute_values' => ['nullable', 'array', 'min:1'],

            'attribute_values.*' => ['integer', 'exists:attribute_values,id'],

        ];
    }

public function passedValidation(): array{

    $product = [
     'price' => $this->product['price'],
     'quantity' => $this->product['quantity'],
     'category_id' => $this->product['category_id'],
     'brand_id' => $this->product['brand_id'],
     'active' => $this->product['active']?? 0,
    ];

    if (request()->isMethod('put') || request()->isMethod('patch')) {
        $colors = $this->colors;
        $colors = collect($colors)->mapWithKeys(function ($item) {
            return [
                $item['color_id'] => ['quantity' => $item['quantity']]
            ];
        });
    }else{
        $colors = $this->colors;
    }

    if($this->has('product.photo') && $this->product['photo']) {
        $product['photo'] = upload_image( $this->product['photo']);
        $newPhoto = $this->product['photo'];
    }

    if($this->has('attribute_values') && $this->attribute_values){
        $attrValues = $this->attribute_values;
    }

    $productLanguages = collect($this->product_translations);

    return  [$product, $productLanguages, $colors, $newPhoto?? "", $attrValues?? ""];
}

    public function messages(): array
    {
        return [
          'required' => 'هذا الحقل مطلوب',
            'colors.*.color_id.required' => 'هذا color id مطلوب',
            'colors.*.quantity.required' => 'هذا quantity مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'language.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'in' => 'القيم المدخلة غير صحيحة',
          'product_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل',
          'integer'  => 'لابد ان يكون رقم',
          'distinct' => 'you cannot choose the same attribute'
        ];
    }

}
