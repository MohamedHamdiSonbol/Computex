<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $orders = Order::Selecting($lang)->get();

//        $start = microtime(true);
//        $products = Product::WithActiveLanguage($lang)->get();
//         return $orders;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.orders.index', compact('lang', 'languages', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $categories =  \App\Models\Category::ActiveCategoriesWithActiveLanguage($lang)->get();
        return view('admin.products.create', compact('lang', 'languages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
//        return request()->all();
        [$productData, $translations, $newPhoto,  $attrValues] = $request->passedValidation();
        try {
            DB::beginTransaction();

            // 1. Create a new Product instance (but don't save yet)
            $product = new Product($productData);

            // 2. Attach the raw file to a temporary property.  the Observer can see it.
            if ($newPhoto) {
                $product->temp_photo = $newPhoto;
            }

            // 3. Save the Category. This triggers the 'creating' event in the Observer.
            $product->save();

            // 4. Create product name translations.
            $product->translations()->createMany($translations);

            // 5. Create attributes values
                $product->attributeValues()->sync($attrValues);

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'تمت إضافة المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            // If the record was created but the transaction failed later
            if (isset($product->photo)) {
                delete_image($product->photo, 'products');
            }
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
    public function edit(Product $product)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $product->load([
            'translations:id,name,slug,description,language_id,product_id',
            'translations.language:id,abbr',
            'attributeValues:id,attribute_id',
            'attributeValues.translation:attribute_value_id,value'
        ]);
        $categories = Category::ActiveCategoriesWithActiveLanguage($lang)->get();
        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
        return view('admin.products.edit', compact('lang', 'languages', 'product', 'categories', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
//        return request()->all();
//        $oldPhoto = $product->photo;                      // old photo to be deleted
        [$productData, $translations, $newPhoto, $attrValues] = $request->passedValidation();
        try {
            DB::beginTransaction();

            if ($newPhoto) {
                $product->temp_photo = $newPhoto;
            }

            $product->update($productData);  // this triggers observer

            foreach ($translations as $trans) {
                $product->translations()->updateOrCreate(
                    [
                        'language_id' => $trans['language_id']  // Search by this
                    ],
                    [
                        'name'        => $trans['name'],
                        'description' => $trans['description']
                    ]
                );
            }

if($attrValues){
    $product->attributeValues()->sync($attrValues);
}else {
    $product->attributeValues()->delete();
}

            /////////////////////////////////////////
//            $product->update($theProduct);
//
//            $productLanguages->transform(function ($val) use ($product){
//                $val['product_id'] = $product->id;
//                $val['slug'] = Str::slug($val['name'] , '-', null);
//                return $val;
//            });
//
//            $product->translations()->upsert($productLanguages->toArray(),
//                ['product_id', 'language_id'],              // unique columns
//                ['name', 'slug', 'description']           // columns to update
//            );
//
//            if(isset($newPhoto) && !empty($newPhoto)){
//                save_image($newPhoto, 'products');
//                delete_image($oldPhoto, 'products');
//            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'تمت تعديل المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.products.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'تمت حذف المنتج بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.products.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Product $product)
    {
        try {
            $product->update([
                'active' => !$product->active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $product->active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

}
