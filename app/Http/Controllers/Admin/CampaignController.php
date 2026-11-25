<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCampaignRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Campaign;
use App\Models\CampaignTranslation;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        //        $start = microtime(true);
        $campaigns = Campaign::WithTranslation($lang)->get();
//         return $campaigns;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.campaigns.index', compact('lang', 'languages', 'campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Campaign::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $types = Campaign::getCampaignableTypes();

        return view('admin.campaigns.create', compact('lang', 'languages','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        $this->authorize('create', Campaign::class);

        [$campaignData, $translations, $discountData] = $request->passedValidation();
//        return $discountData;
//        return $translations;
        try {
            DB::beginTransaction();

            // 1. Create a new Product instance (but don't save yet)
            $campaign = Campaign::create($campaignData);

            $campaign->translations()->createMany($translations);

            $campaign->discount()->create($discountData);

            DB::commit();
//            return 'good';
            return redirect()->route('admin.campaigns.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();

//            return $ex->getMessage();
            return redirect()->route('admin.products.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $languageId = Language::where('abbr', $lang)->value('id');

        $campaign->load([
            'translations:id,campaign_id,language_id,name,description',
            'translations.language:id,abbr',
            'discount',
        ]);

        $types = Campaign::getCampaignableTypes();
        $type = $campaign->campaignable_type;
//        return $type;

        $campaignableIds = match($type) {
            'brand'    => BrandTranslation::where('language_id', $languageId)->select('brand_id as id', 'name')->whereHas('brand', fn($q) => $q->where('is_active', true))->orderBy('name')->get(),

            'category' => CategoryTranslation::where('language_id', $languageId)->select('category_id as id', 'name')->whereHas('category', fn($q) => $q->where('active', 1))->orderBy('name')->get(),

            'product'  => ProductTranslation::where('language_id', $languageId)->select('product_id as id', 'name')->whereHas('product', fn($q) => $q->where('active', 1))->orderBy('name')->get(),

            default    => collect(), // The 'else' case
        };
//        return $type;
//        return $campaignableIds;
//        return $campaign;
        return view('admin.campaigns.edit', compact('lang', 'languages', 'campaign', 'types', 'campaignableIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCampaignRequest $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        [$campaignData, $translations, $discountData] = $request->passedValidation();
//        return $campaignData;
//        return $translations;
        try {
            DB::beginTransaction();

            $campaign->update($campaignData);

                    $start = microtime(true);


            $translationData = collect($translations)->map(fn($trans) => [
                'campaign_id' => $campaign->id,
                'language_id' => $trans['language_id'],
                'name'        => $trans['name'],
                'description' => $trans['description'],
            ])->toArray();

            CampaignTranslation::upsert(
                $translationData,
                ['campaign_id', 'language_id'],
                ['name', 'description']
            );

            $campaign->discount->update($discountData);

            DB::commit();
//            return 'good';
            return redirect()->route('admin.campaigns.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.campaigns.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        try {
            DB::beginTransaction();
            $campaign->delete();
            $campaign->discount()->delete();
            DB::commit();
            return redirect()->route('admin.campaigns.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.campaigns.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Campaign $campaign)
    {
        try {
            $campaign->update([
                'is_active' => !$campaign->is_active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $campaign->is_active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }







    public function fetchCampaignableId($type){
        try{
            $lang = get_active_lang();
            $languageId = Language::where('abbr', $lang)->value('id');

            $types = array_keys(Campaign::getCampaignableTypes());
            if (!in_array($type, $types)) {
                return response()->json([
                    'message' => 'Wrong input data',
                ]);

            } else{
                $data = match($type) {
                    'brand'    => BrandTranslation::where('language_id', $languageId)->select('brand_id as id', 'name')->whereHas('brand', fn($q) => $q->where('is_active', true))->orderBy('name')->get(),

                    'category' => CategoryTranslation::where('language_id', $languageId)->select('category_id as id', 'name')->whereHas('category', fn($q) => $q->where('active', 1))->orderBy('name')->get(),

                    'product'  => ProductTranslation::where('language_id', $languageId)->select('product_id as id', 'name')->whereHas('product', fn($q) => $q->where('active', 1))->orderBy('name')->get(),

                    default    => collect(), // The 'else' case
                };

                return response()->json([
                    'campaignableIds' => $data,
                ]);
            }
//            return response()->json([
//                'cities' => $types,
//            ]);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
