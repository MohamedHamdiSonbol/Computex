<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCampaignRequest;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Campaign;
use App\Models\CampaignTranslation;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Coupon;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        //        $start = microtime(true);
        $coupons = Coupon::WithDiscount()->get();
//         return $coupons;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.coupons.index', compact('lang', 'languages', 'coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Coupon::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.coupons.create', compact('lang', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $this->authorize('create', Coupon::class);

        $validatedData = $request->validated();
        $couponData = $validatedData['coupon'];
        $discountData = $validatedData['discount'];
        try {
            DB::beginTransaction();

            // 1. Create a new Product instance (but don't save yet)
            $coupon = Coupon::create($couponData);

            $coupon->discount()->create($discountData);


            DB::commit();
//            return 'good';
            return redirect()->route('admin.coupons.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();

//            return $ex->getMessage();
            return redirect()->route('admin.coupons.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $coupon->load('discount');
//        return $coupon;
        return view('admin.coupons.edit', compact('lang', 'languages',  'coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $validatedData = $request->validated();

        $couponData = $validatedData['coupon'];
        $discountData = $validatedData['discount'];
//        return $couponData;
//        return $discountData;
        try {
            DB::beginTransaction();

            $coupon->update($couponData);
            $coupon->discount()->update($discountData);

            DB::commit();
//            return 'good';
            return redirect()->route('admin.coupons.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
//            return $ex->getMessage();
            return redirect()->route('admin.coupons.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        try {
            DB::beginTransaction();
            $coupon->delete();
            $coupon->discount()->delete();
            DB::commit();
            return redirect()->route('admin.coupons.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.coupons.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Coupon $coupon)
    {
        try {
            $coupon->update([
                'is_active' => !$coupon->is_active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $coupon->is_active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

}
