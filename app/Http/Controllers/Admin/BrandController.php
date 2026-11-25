<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $start = microtime(true);
        $lang = get_active_lang();
        $languages = get_active_languages();
        $brands = Brand::WithTranslation($lang)->get();
//         return $brands;
//        $end = microtime(true);
//        dd(($end - $start) * 1000);
        return view('admin.brands.index', compact('lang', 'languages','brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.brands.create', compact('lang', 'languages',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        [$brandData, $translations , $newPhoto] = $request->passedValidation();
//        return $brandData;
//        return $translations;
//        return $newPhoto;
        try {
            DB::beginTransaction();

            // 1. Create a new Product instance (but don't save yet)
            $brand = new Brand($brandData);
            // 2. Attach the raw file to a temporary property.  the Observer can see it.
            if ($newPhoto) {
                $brand->temp_photo = $newPhoto;
            }
            // 3. Save the Category. This triggers the 'creating' event in the Observer.
            $brand->save();
            // 4. Create product name translations.
            $brand->translations()->createMany($translations);

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            // If the record was created but the transaction failed later
            if (isset($brand->logo)) {
                delete_image($brand->logo, 'brands');
            }
            return redirect()->route('admin.brands.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Brand $brand)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $brand = $brand->loadBrandData()->makeHidden(['created_at', 'updated_at']);
//        return $brand;
        return view('admin.brands.edit', compact('lang', 'languages', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBrandRequest $request, Brand $brand)
    {
//        return request()->all();
//        $oldPhoto = $brand->photo;                      // old photo to be deleted
        [$brandData, $translations , $newPhoto]= $request->passedValidation();
//        return $brandData;
//        return $translations;
//        return $newPhoto;
        try {
            DB::beginTransaction();

            if ($newPhoto) {
                $brand->temp_photo = $newPhoto;
            }

            $brand->update($brandData);  // this triggers observer

            foreach ($translations as $trans) {
                $brand->translations()->updateOrCreate(
                    [
                        'language_id' => $trans['language_id']  // Search by this
                    ],
                    [
                        'name'        => $trans['name'],
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.brands.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            DB::beginTransaction();
            $brand->delete();
            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.brands.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Request $request, Brand $brand)
    {
        try {
            $brand->update([
                'is_active' => !$brand->is_active
            ]);
            return response()->json([
                'success' => true,
                'active'  => $brand->is_active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        }catch (ValidationException $e) {
            // Re-throw so Laravel responds with 422 and field errors
            throw $e;

        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

}
