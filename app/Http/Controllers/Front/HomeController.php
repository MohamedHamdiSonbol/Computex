<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\BrandResource;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\GovernorateResource;
use App\Http\Resources\Front\ProductResource;
use App\Services\Front\BrandService;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\GovernorateService;
use App\Services\Front\ProductService;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryService $categoryServ, BrandService $brandServ, ProductService $productServ, CartItemService $cartItemServ, GovernorateService $governorateServ)
    {
        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();
//        $data = $productServ->getNewArrivalProduct($lang);
//            return ProductResource::collection($data)->resolve();

        $customer = Auth::guard('customers')->user();
//        $categories = Cache::remember("categories_{$lang}", 3600, function() use ($lang) {
//            return Category::ActiveCategoriesWithActiveLanguage($lang)->get();
//        });

        $rawGovernorates = $governorateServ->getAllGovernoratesWithTranslations($lang);
        $governorates = GovernorateResource::collection($rawGovernorates)->resolve();
//        return $governorates;

//        $rawTopProducts = $productServ->getTopSellingProducts($lang);
//        $topProducts = ProductResource::collection($rawTopProducts)->resolve();
//        return $rawTopProducts;

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
//        return $rawCategories;
//        return $categories;
//

        $rawBrands = $brandServ->getHomeBrands($lang);
        $brands = BrandResource::collection($rawBrands)->resolve();
//        return $brands;


        $rawProducts = $productServ->getHomeProductsWithDiscounts($lang);
        $products = ProductResource::collection($rawProducts)->resolve();
//        return $rawProducts;
//        return $products;

        $rawBiggestDiscountProduct = $productServ->getBiggestDiscountProduct($lang);
        $biggestDiscountProduct = $rawBiggestDiscountProduct ? (new ProductResource($rawBiggestDiscountProduct))->resolve() : null;
//        return $rawBiggestDiscountProduct;

//        $biggestDiscountProduct = null;
        $rawTopSellingProduct = $productServ->getTopSellingProduct($lang);
        $topSellingProduct = $rawTopSellingProduct ? (new ProductResource($rawTopSellingProduct))->resolve() : null;
//        return $biggestDiscountProduct;
//        return $topSellingProduct;

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

//        $end = microtime(true);
//        $durationInMs = ($end - $start) * 1000;
//        dd($durationInMs . ' ms');
        return view('front.home', compact('lang', 'categories', 'brands', 'cartCount', 'products', 'languages', 'biggestDiscountProduct', 'topSellingProduct'));
    }


    public function fetchNewArrivalProducts(ProductService $productServ){
        try{
            $lang = get_active_lang();
            $rawNewProducts = $productServ->getNewArrivalProduct($lang);
            $data = ProductResource::collection($rawNewProducts)->resolve();

            return response()->json($data);

        } catch (\Exception $ex){
            return response()->json(['success' => false], 500);
        }
    }


    public function fetchTopSellingProducts(ProductService $productServ){
        try{
            $lang = get_active_lang();
            $rawTopProducts = $productServ->getTopSellingProducts($lang);
            $data = ProductResource::collection($rawTopProducts)->resolve();
            return response()->json($data);

        } catch (\Exception $ex){
            return response()->json(['success' => false], 500);
        }
    }
}
