<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\BrandResource;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\ProductResource;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\CartItem;
use App\Services\Front\AttributeService;
use App\Services\Front\BrandService;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(BrandTranslation $brand,  CategoryService $categoryServ, BrandService $brandServ,  AttributeService $attributeServ, ProductService $productServ, CartItemService $cartItemServ)
    {
//        return $brand;
        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();

        $attributes = $attributeServ->getAttributesNamesAndValues($lang, $brand->brand_id, null);
//        return $attributes;

        $rawBrands = $brandServ->getHomeBrands($lang);
        $brands = BrandResource::collection($rawBrands)->resolve();
//        return $brands;

        [$rawProducts, $cleanPrices] = $productServ->getProductsOfOneBrand($brand->brand_id, $lang);
        $products = ProductResource::collection($rawProducts)->resolve();
//        return $rawProducts;
//        return $products;

        $minPrice = $cleanPrices->min(); // Returns 7492.45
        $maxPrice = $cleanPrices->max(); // Returns 12836.79
//        return $minPrice;
//        return $maxPrice;

        $rawBrand =  $brandServ->getLoadBrandTranslationsRelations($brand);
        $brand = $rawBrand ? (new BrandResource($rawBrand))->resolve() : null;
//        return $category;

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

//        $end = microtime(true);
//        $durationInMs = ($end - $start) * 1000;
//        dd($durationInMs . ' ms');

        return view('front.brand', compact('lang', 'brands', 'categories', 'attributes', 'languages', 'cartCount', 'products', 'rawProducts', 'minPrice', 'maxPrice', 'brand'));
    }


    public function filter(Request $request, Brand $brand, BrandService $brandServ){
        try{
            $lang = get_active_lang();
            $attrValIds = $request->input('attrValIds', []);
            $sortType = $request->input('sortType');
            $priceMin = $request->input('priceMin');
            $priceMax = $request->input('priceMax');

            [$rawProducts, $valuesCounts] = $brandServ->getFilteredBrands($lang, $brand->id, $attrValIds, $sortType, $priceMin, $priceMax);
            $products = ProductResource::collection($rawProducts?? collect([]))->resolve();
//            return response()->json($attrValIds);
            return response()->json([
                'status'        => 'success',
                'products'      => $products,
                'valuesCounts'  => $valuesCounts,
                'priceMin'      => $priceMin?? null,
                'priceMax'      => $priceMax?? null,
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





