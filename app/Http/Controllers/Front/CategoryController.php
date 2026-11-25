<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\ProductResource;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Services\Front\AttributeService;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(CategoryTranslation $category, CategoryService $categoryServ, AttributeService $attributeServ, ProductService $productServ, CartItemService $cartItemServ)
    {
        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $attributes = $attributeServ->getAttributesNamesAndValues($lang, null, $category->category_id);
//        return $attributes;

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
//        return $categories;

        $rawProducts = $productServ->getProductsOfOneCategory($category->category_id, $lang);
        $products = ProductResource::collection($rawProducts)->resolve();
//        return $products;

        $rawCategory =  $categoryServ->getLoadCategoryTranslationsRelations($category);
        $category = $rawCategory ? (new CategoryResource($rawCategory))->resolve() : null;
//        return $category;

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

//        $end = microtime(true);
//        $durationInMs = ($end - $start) * 1000;
//        dd($durationInMs . ' ms');

        return view('front.category', compact('lang', 'categories', 'attributes', 'languages', 'cartCount', 'products', 'rawProducts', 'category'));
    }



    public function sort(Request $request, Category $category, CategoryService $categoryServ){
        try{
            $lang = get_active_lang();
            $sortType = $request->input('sortType');

            $result = $categoryServ->getSortedCategories($lang, $category->id, $sortType);
            $products = ProductResource::collection($result?? collect([]))->resolve();
//            return response()->json($result);
            return response()->json([
                'status'    => 'success',
                'products'   => $products,
            ]);

        }catch(\Exception $e){
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

    }


    public function filter(Request $request, Category $category, CategoryService $categoryServ){
        try{
            $lang = get_active_lang();
            $attrValIds = $request->input('attrValIds', []);
            $sortType = $request->input('sortType');

            [$rawProducts, $valuesCounts] = $categoryServ->getFilteredCategories($lang, $category->id, $attrValIds, $sortType);
            $products = ProductResource::collection($rawProducts?? collect([]))->resolve();
//            return response()->json([$rawProducts, $valuesCounts]);

            return response()->json([
                'status'        => 'success',
                'products'      => $products,
                'valuesCounts'  => $valuesCounts,
            ]);

        }catch(\Exception $e){
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

    }


}





