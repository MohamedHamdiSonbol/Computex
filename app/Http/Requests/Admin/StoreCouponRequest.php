<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
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

        $id = $this->route('coupon')?->id;
//        dd($id);

        return [
            'coupon.code'                    => [
                                                 'required',
                                                 'string',
                                                 'max:50',
                                                 Rule::unique('coupons', 'code')->ignore($id, 'id'),
                                                ],

            'coupon.starts_at'             => ['required', 'date'],

            'coupon.ends_at'               => ['required', 'date'],

            'coupon.is_active'             => ['boolean'],
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            'discount'                       => ['required','array', 'min:1'],

            'discount.type'                  => ['required', 'string', 'max:15', 'in:fixed,percentage'] ,

            'discount.value'                 => ['required', 'numeric', 'min:1'],

            'discount.min_quantity'          => ['required', 'integer', 'min:1'],

            'discount.min_order_value'       => ['nullable', 'numeric', 'min:1'],

            'discount.usage_limit_per_user'  => ['nullable', 'integer', 'min:1'],

            'discount.is_active'             => ['boolean'],
        ];
    }

//public function passedValidation(): array{
//
////    $campaignData = request('campaign');
////    $discountData = request('discount');
//
//}


    public function messages(): array
    {
        return [
//          'required' => 'هذا الحقل مطلوب',
          'string' => 'الحقل لابد ان يكون أحرف',
          'language.max' => 'اسم اللغة لابد الا يزيد عن 10 حرف',
          'name.max' => 'اسم اللغة لابد الا يزيد عن 100 حرف',
          'in' => 'القيم المدخلة غير صحيحة',
//          'category_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل', // Custom unique message
          'category_translations.*.name.unique'  => 'هذا اسم مستخدم من قبل', // Custom unique message
        ];
    }

}
