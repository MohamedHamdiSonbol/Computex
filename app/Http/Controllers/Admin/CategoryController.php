<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $categories = Category::WithTranslation($lang)->get();
        foreach ($categories as $category) {
            $category->name = $category->translation->name ?? null;
            $category->slug = $category->translation->slug ?? null;
            $category->makeHidden('translation');
        }
//        return $categories;
        return view('admin.categories.index', compact('lang', 'languages','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.categories.create', compact('lang', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        [$categoryData, $translations, $newPhoto ] = $request->passedValidation();

//        return $categoryData;
        try {
            DB::beginTransaction();
            // 1. Create a new Category instance (but don't save yet)
            $category = new Category($categoryData);

            // 2. Attach the raw file to a temporary property.  the Observer can see it.
            if ($newPhoto) {
                $category->temp_photo = $newPhoto;
            }

            // 3. Save the Category. This triggers the 'creating' event in the Observer.
            $category->save();

//            foreach($translations as $trans){
//                $category->translations()->create($trans);
//            }
                $category->translations()->createMany($translations);


            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'تمت إضافة القسم بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();

            // If the record was created but the transaction failed later
            if (isset($category->photo)) {
                delete_image($category->photo, 'categories');
            }
            return redirect()->route('admin.categories.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $category = $category->WithLoadCategoryActiveTranslationRelation($lang);
//return $category;
        return view('admin.categories.show', compact('lang', 'languages', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        $lang = get_active_lang();
        $languages = get_active_languages();
      $category =  $category->WithLoadCategoryTranslationsRelations();
//        foreach ($category->translations as $trans) {
//            $cat->id = $cat->id ?? null;
//            $cat->photo = $cat->photo ?? null;
//            $cat->active = $cat->active ?? null;
//            $trans->name = $trans->name ?? null;
//            $trans->slug = $trans->slug ?? null;
//            $trans->description = $trans->description ?? null;
//            $trans->category_id = $trans->category_id ?? null;
//            $trans->language_id = $trans->language_id ?? null;
//            $trans->abbr = $trans->language->abbr ?? null;
//            $trans->makeHidden('language');
//        }
//        $category =  $category->load('translations.language:id,abbr');
//        return $category;
        return view('admin.categories.edit', compact('lang', 'languages', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        [$categoryData, $translations, $newPhoto] = $request->passedValidation();

        try {
            DB::beginTransaction();

            if ($newPhoto) {
                $category->temp_photo = $newPhoto;
            }

            $category->update($categoryData);  // this triggers observer

            foreach ($translations as $trans) {
                $category->translations()->updateOrCreate(
                    [
                        'language_id' => $trans['language_id']  // Search by this
                    ],
                    [
                        'name'        => $trans['name'],
                        'description' => $trans['description']
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'تمت تعديل القسم بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.categories.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        try {
            DB::beginTransaction();
            if($category->products()->count() > 0){
                return to_route('admin.categories.index')->with('error', 'لا يمكن حذف هذا القسم لأنه يحتوي على منتجات');
            }
            else{
                $category->delete();
            }
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'تمت حذف القسم بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.categories.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Category $category)
    {
        try {
            $category->update([
                'active' => !$category->active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $category->active,
                'message' => 'تم تحديث الحالة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }


    public function truncate(Category $category)
    {
        try {
            $products = $category->products;

            if ($products->count() > 0) {
                // 1. Manually delete all images in one go
                foreach ($products as $product) {
                    if ($product->photo) {
                        delete_image($product->photo, 'products');
                    }
                }

                // 2. Delete all products with one fast SQL query
                $category->products()->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'تم إخلاء القسم بنجاح'
                ]);
            } else {
                // If the category is already empty
                return response()->json([
                    'success' => false,
                    'message' => 'هذا القسم فارغ بالفعل'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطأ في النظام'], 500);
        }
    }

}





