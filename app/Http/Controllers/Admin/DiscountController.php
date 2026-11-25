<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiscountRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\CampaignTranslation;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        //        $start = microtime(true);
        $discounts = Discount::WithCampaigns($lang)->get();
//         return $discounts;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.discounts.index', compact('lang', 'languages','discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $languageId = Language::where('abbr', $lang)->value('id');
        $campaigns = CampaignTranslation::where('language_id', $languageId)->select('campaign_id as id', 'name')->whereHas('campaign', fn($q) => $q->where('is_active', true))->orderBy('name')->get();
//        return $campaigns;
//        $categories =  \App\Models\Category::ActiveCategoriesWithActiveLanguage($lang)->get();
        return view('admin.discounts.create', compact('lang', 'languages', 'campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
//        return request()->all();
        $discountData = $request->passedValidation();
//        return $discountData;
        try {
            DB::beginTransaction();

             Discount::create($discountData);

            DB::commit();
//            return 'good';
            return redirect()->route('admin.discounts.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//          return $ex->getMessage();
            return redirect()->route('admin.discounts.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Discount $discount)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $languageId = Language::where('abbr', $lang)->value('id');
        $campaigns = CampaignTranslation::where('language_id', $languageId)->select('campaign_id as id', 'name')->whereHas('campaign', fn($q) => $q->where('is_active', true))->orderBy('name')->get();
//        return $discount;
        return view('admin.discounts.edit', compact('lang', 'languages','campaigns', 'discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDiscountRequest $request, Discount $discount)
    {
        $validatedData = $request->validated();
        $discountData = $validatedData['discount'];

        try {
            DB::beginTransaction();
            $discount->update($discountData);
            DB::commit();
            return redirect()->route('admin.discounts.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.discounts.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        try {
            DB::beginTransaction();
            $discount->delete();
            DB::commit();
            return redirect()->route('admin.discounts.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.discounts.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Discount $discount)
    {
        try {
            $discount->update([
                'is_active' => !$discount->is_active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $discount->is_active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

}
