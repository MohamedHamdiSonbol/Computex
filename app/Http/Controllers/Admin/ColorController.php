<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\StoreColorRequest;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $colors = Color::GetAllColors($lang)->get();
//        return $colors;
        return view('admin.colors.index', compact('lang', 'languages', 'colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->authorize('create', Color::class);
        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.colors.create', compact( 'lang', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
//        $this->authorize('create', Category::class);

        $color = $request->passedValidation();
//        return $color;
        try {
            Color::create($color);
            return redirect()->route('admin.colors.create')->with('success', 'تمت إضافة القسم بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.colors.create')->with('error', 'هناك خطأ ما' . $ex->getMessage());
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
    public function edit(Color $color)
    {
//        $this->authorize('update', $category);
        $lang = get_active_lang();
        $languages = get_active_languages();
//        return $color;
        return view('admin.colors.edit', compact('lang', 'languages', 'color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreColorRequest $request, Color $color)
    {
//        $this->authorize('update', $category);
        $colorData = $request->passedValidation();

        try {
            $color->update($colorData);

            return redirect()->route('admin.colors.index')->with('success', 'تمت تعديل القسم بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.colors.index')->with('error', 'هناك خطأ ما'. $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
//        $this->authorize('delete', $category);
        try {
            DB::beginTransaction();
            if($color->products()->exists()){
                return to_route('admin.colors.index')->with('error', 'لا يمكن حذف هذا اللون لأنه يحتوي على منتجات');
            }
            else{
                $color->delete();
            }
            DB::commit();
            return redirect()->route('admin.colors.index')->with('success', 'تمت حذف القسم بنجاح');
        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.colors.index')->with('error', 'هناك خطأ ما');
        }
    }



    public function toggleStatus(Color $color)
    {
        try {
            $color->update([
                'is_active' => !$color->is_active
            ]);

            return response()->json([
                'success' => true,
                'active'  => $color->is_active,
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



    public function fetchColors(){
        try{
            $lang = get_active_lang();
            $data = Color::GetAllColors($lang)->get();
            //            return $data;
            return response()->json($data);

        } catch (\Exception $ex){
            return response()->json(['success' => false], 500);
        }
    }



}





