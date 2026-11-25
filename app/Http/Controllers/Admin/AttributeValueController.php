<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttributeRequest;
use App\Http\Requests\Admin\StoreAttributeValueRequest;
use App\Http\Requests\Admin\StoreLanguageRequest;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $lang;

    public function __construct()
    {
        $this->lang = get_active_lang();
    }

    public function index(Attribute $attribute)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        //        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
        $values = AttributeValue::Select_Attr_Value_Trans_main_active_lang($this->lang, $attribute->id)->get();

//        foreach ($values as $value) {
//            return $value->translation->value;
//        }
//        return $values;

        return view('admin.attributes.values_index', compact('lang', 'languages', 'values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
//        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
//        return $attributes;
        return view('admin.attributes.values_create', compact('lang', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeValueRequest $request, Attribute $attribute)
    {
        [$translations] = $request->passedValidation();
        try {
            DB::beginTransaction();

           foreach($translations as $trans) {
            $valueId =  $attribute->values()->create();
            $valueId->translations()->createMany($trans);
           }

            DB::commit();
//            return 'good';
            return redirect()->route('admin.attribute_values.index', $attribute->id)->with('success', 'تمت إضافة الخاصية بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.attribute_values.index', $attribute->id)->with('error', 'هناك خطأ ما');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute, AttributeValue $attributeValue)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $value = $attributeValue->load([
            'translations:id,attribute_value_id,language_id,value',
            'translations.language:id,abbr'
        ]);
//        return $value;
        return view('admin.attributes.values_edit', compact('lang', 'languages','value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttributeValueRequest $request, Attribute $attribute, AttributeValue $attributeValue)
    {
        [$translations] =  $request->passedValidation();
        try {
            foreach ($translations as $trans) {
                $attributeValue->translations()->updateOrCreate(
                    ['language_id' => $trans['language_id']], // How to find the row
                    ['value' => $trans['value']]                // What to update
                );
            }

             $id= $attribute->id;
//            return 'good';
            return redirect()->route('admin.attribute_values.index', $id)->with('success', 'تمت تعديل الخاصية بنجاح');
        } catch (\Exception $ex){

//return $ex->getMessage();
            return redirect()->route('admin.attribute_values.index', $id)->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute, AttributeValue $attributeValue)
    {
        try {
                if ($attributeValue->whereHas('products')->exists()) {
                    return redirect()
                        ->route('admin.attribute_values.index', $attribute->id)
                        ->with('error', 'لا يمكن حذف هذه القيمة لأن بعض المنتجات تستخدمها');
                }

            $attributeValue->delete();

                return redirect()->route('admin.attribute_values.index', $attribute->id)->with('success', 'تمت حذف الخاصية بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.attribute_values.index', $attribute->id)->with('error', 'هناك خطأ ما');
        }
    }



    public function fetchAttributeValues(Attribute $attribute){
        try{
            $lang = $this->lang;
            $data = AttributeValue::Select_Attr_Value_Trans_main_active_lang($lang, $attribute->id)->get();
            //            return $data;
            return response()->json($data);

        } catch (\Exception $ex){
            return response()->json(['success' => false], 500);
        }
    }








//    public function createValue(Attribute $attribute){
//        $lang = get_active_lang();
//        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
////        return $attributes;
//        return view('admin.attributes.add_value', compact(['attributes', 'lang']));
//    }
}
