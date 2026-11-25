<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCampaignRequest extends FormRequest
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

        $id = $this->route('campaign')?->id;
//        dd($id);

        $type = request('campaign.campaignable_type');

        // Get the table name from your Morph Map or a simple array
        [$table, $statusColumn] = match($type) {
            'brand'    => ['brands', 'is_active'],
            'category' => ['categories', 'active'],
            'product'  => ['products', 'active'],
            default    => [null, null],
        };

        $rules = [
            Rule::requiredIf($type !== 'all'),
        ];

        if ($type === 'all') {
            $rules[] = 'nullable';
        } else {
            $rules[] = 'required';
            $rules[] = 'integer';

            // Add the exists rule only if we have a table
            if ($table) {
                $rules[] = Rule::exists($table, 'id')->where($statusColumn, 1);
            }
        }
        return [
            'campaign_translations'               => ['required','array', 'min:1'],

            'campaign'                            => ['required','array', 'min:1'],

            'campaign_translations.*.language_id' => [
                                                      'required',
                                                      'integer',
                                                      'exists:languages,id',
            ],

            'campaign_translations.*.name'        => [
                                                      'required',
                                                      'string',
                                                      'max:100',
                                                      // exclude the update where id == category_id
                                                      Rule::unique('campaign_translations', 'name')->ignore($id, 'campaign_id'),
            ],

            'campaign_translations.*.description' => [
                                                      'required',
                                                      'string',
                                                      'max:100',
                                                      // exclude the update where id == category_id
                                                      Rule::unique('campaign_translations', 'description')->ignore($id, 'campaign_id'),
            ],

//            'campaign.photo'     => ['nullable', 'mimes:jpg,jpeg,png,webp,avif', 'max:3000'],

            'campaign.campaignable_type'          => ['required', 'string', 'in:all,category,brand,product'],

            'campaign.campaignable_id'            => $rules,

            'campaign.priority'                  => ['required', 'integer'],

            'campaign.starts_at'                 => ['required', 'date'],

            'campaign.ends_at'                   => ['required', 'date'],

            'campaign.is_active'                    => ['boolean'],

            'campaign.stackable'                 => ['boolean'],
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

public function passedValidation(): array{

    $campaignData = request('campaign');
    $discountData = request('discount');

    if($campaignData['campaignable_type'] === 'all'){
        $campaignData['campaignable_type'] = null;
        $campaignData['campaignable_id'] = null;
    }

    $campaignData = [
        'starts_at'         => $campaignData['starts_at'],
        'ends_at'           => $campaignData['ends_at'],
        'campaignable_type' =>  $campaignData['campaignable_type'],
        'campaignable_id'   =>  $campaignData['campaignable_id'],
        'priority'          =>  $campaignData['priority'],
        'is_active'            =>  $campaignData['is_active']?? 0,
        'is_stackable'         =>  $campaignData['is_stackable']?? 0,
    ];

    $translationData = request('campaign_translations');

    return  [$campaignData, $translationData, $discountData];
}


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
