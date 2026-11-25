<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        //        $start = microtime(true);
        $products = Product::WithTranslation($lang)
            ->WithCategoryName()
//            ->orderBy('id')
            ->get();
//         return $products;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.products.index', compact('lang', 'languages', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $categories =  Category::WithTranslation($lang)->get();
        $brands =  Brand::WithTranslation($lang)->get();
        $colors = Color::GetAllColors($lang)->get();
        $oldColors = old('colors', []);

        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
        $attributesValues = AttributeValue::SelectAll_Attr_Value_Trans_main_active_lang($lang)->get()->groupBy('attribute_id');
        $oldAttributes = old('attributes', []);
        $oldAttributeValues = old('attribute_values', []);
        $filteredData = $attributesValues->filter(function($group, $attrId) use ($oldAttributes) {
            // Only keep groups that are present in the old 'attributes' input
            return in_array($attrId, $oldAttributes);
        });
//        return $colorCount;
//        return $oldAttributeValues;
//        return $filteredData;
//        return $attributesValues;
        return view('admin.products.create', compact('lang', 'languages', 'categories', 'brands', 'colors', 'oldColors', 'attributes', 'attributesValues', 'filteredData', 'oldAttributes', 'oldAttributeValues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

//        return request()->all();
        [$productData, $translations, $colors, $newPhoto,  $attrValues] = $request->passedValidation();
//        return $productData;
//        return $translations;
//        return $attrValues;
//        return $colors;
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

            // 5. Create colors & quantities values
            $product->colors()->sync($colors);

            // 6. Create attributes values
            if($attrValues){
                $product->attributeValues()->sync($attrValues);
            }

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
        $start = microtime(true);

        $this->authorize('update', $product);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $product->loadProductAllWithData($lang);
//return $product;

        $categories = Category::WithTranslation($lang)->get();
        $brands = Brand::WithTranslation($lang)->get();
        $attributes = Attribute::SelectOneAttr_transWithActiveLang($lang)->get();
        $colors = Color::GetAllColors($lang)->get();
//        return $colors;
        $oldColors = old('colors', []);

        $ids = $product->attributeValues()->pluck('attribute_id')->toArray();
        $attributesValues = AttributeValue::Select_Attr_Values_Trans_main_active_lang($lang, $ids)->get();
        $attributesValues = $attributesValues->map(function ($item) {
            $item->value = $item->translation->value ?? null; // Flatten the structure: move 'value' to the root level
            unset($item->translation); // Remove the translation object to keep the payload small
            return $item;
        })->groupBy('attribute_id')->values();

        $allAttributesValues = AttributeValue::SelectAll_Attr_Value_Trans_main_active_lang($lang)->get()->groupBy('attribute_id');
        $oldAttributes = old('attributes', []);
        $oldAttributeValues = old('attribute_values', []);
        $filteredData = $allAttributesValues->filter(function($group, $attrId) use ($oldAttributes) {
            // Only keep groups that are present in the old 'attributes' input
            return in_array($attrId, $oldAttributes);
        });
//        return $oldColors;
//        return $product['attributeValues'];
//        return $product;
//        $end = microtime(true);
//        dd($end - $start);
        return view('admin.products.edit', compact('lang', 'languages', 'product', 'categories', 'brands', 'colors', 'oldColors', 'attributes', 'attributesValues', 'allAttributesValues', 'filteredData', 'oldAttributes', 'oldAttributeValues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

//        return request()->all();
//        $oldPhoto = $product->photo;                      // old photo to be deleted
        [$productData, $translations, $colors, $newPhoto, $attrValues] = $request->passedValidation();
//        return $colors;
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

            $product->colors()->sync($colors);


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
        $this->authorize('delete', $product);

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
        $this->toggleActive('delete', $product);

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
