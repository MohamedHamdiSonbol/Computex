<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttributeRequest;
use App\Http\Requests\Admin\StoreLanguageRequest;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
//        return $attributes;
        return view('admin.attributes.index', compact('lang', 'languages', 'attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Attribute::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
//        return $attributes;
        return view('admin.attributes.create' , compact('lang', 'languages', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $this->authorize('create', Attribute::class);

         [$attributeData, $translations] =  $request->passedValidation();
//return $attributeData;
        try {
            DB::beginTransaction();
           $attribute =  Attribute::create($attributeData);
           $attribute->translations()->createMany($translations);
            DB::commit();
            return redirect()->route('admin.attributes.create')->with('success', 'تمت إضافة الخاصية بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.attributes.create')->with('error', 'هناك خطأ ما');
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
    public function edit(Attribute $attribute)
    {
        $this->authorize('update', $attribute);
        $lang = get_active_lang();
        $languages = get_active_languages();
        $attribute = $attribute->load('translations:attribute_id,language_id,name', 'translations.language:id,abbr');
        return view('admin.attributes.edit', compact('lang', 'languages','attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAttributeRequest $request, Attribute $attribute)
    {
        $this->authorize('update', $attribute);

        [$attributeData, $translations] =  $request->passedValidation();

        try {
            DB::beginTransaction();
            $attribute->update($attributeData);

            foreach ($translations as $trans) {
                $attribute->translations()->updateOrCreate(
                    ['language_id' => $trans['language_id']], // How to find the row
                    ['name' => $trans['name']]                // What to update
                );
            }
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('success', 'تمت تعديل الخاصية بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();

            return redirect()->route('admin.attributes.index')->with('error', 'هناك خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $this->authorize('delete', $attribute);

        try {
            if ($attribute->values()->whereHas('products')->exists()) {
                return redirect()
                    ->route('admin.attributes.index')
                    ->with('error', 'لا يمكن حذف هذه الخاصية لأن بعض المنتجات تستخدمها');
            }

            $attribute->delete();

            return redirect()->route('admin.attributes.index')->with('success', 'تمت حذف الخاصية بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.attributes.index')->with('error', 'هناك خطأ ما');
        }
    }

    public function toggleStatus(Attribute $attribute){
        try {
            $attribute->update([
                'active' => !$attribute->active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $attribute->active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }



    public function fetchAttributes(){
            try{
                $lang = get_active_lang();
                $data = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
    //            return $data;
                return response()->json($data);

            } catch (\Exception $ex){
                return response()->json(['success' => false], 500);
            }
    }


}
