<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\ProductResource;
use App\Models\Attribute;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\ProductTranslation;
use App\Services\Front\AttributeService;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{

    public function search(Request $request, CategoryService $categoryServ, ProductService $productServ, AttributeService $attributeServ, CartItemService $cartItemServ){
        try{
            $lang = get_active_lang();
            $languages = get_active_languages();
            $customer = Auth::guard('customers')->user();

            $rawCategories = $categoryServ->getHomeCategories($lang);
            $categories = CategoryResource::collection($rawCategories)->resolve();
            //return $categories;

            $cartCount = $cartItemServ->getCartCount($customer->id?? null);

//           return $request->all();
           $searchQuery = $request->input('searchTerm');
           $categoryId = $request->input('categoryId'); // e.g., from a dropdown or URL parameter
//            return $searchQuery;
//            return $categoryId;

            $attributes = $attributeServ->getAttributesNamesAndValues($lang, null, null);
//        return $attributes;

            $rawProducts = $productServ->getSearchResults($searchQuery, $categoryId);
            $products = ProductResource::collection($rawProducts)->resolve();
//            return $rawProducts;
//                            dd([
//            'Type of Variable' => gettype($rawProducts),
//            'Is it a Collection?' => $rawProducts instanceof \Illuminate\Support\Collection ? 'Yes' : 'No',
//            'Raw Data Dump' => $rawProducts
//        ]);

            return view('front.product-search' , compact('lang', 'languages', 'categories',  'cartCount', 'attributes', 'products' , 'rawProducts'));
        } catch(\Exception $e){
            return 'bad';
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(ProductTranslation $product,  CategoryService $categoryServ, ProductService $productServ, CartItemService $cartItemServ)
    {
        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();

        $rawProduct =  $productServ->getLoadProductTranslationsRelations($product, $lang);
        $product = $rawProduct ? (new ProductResource($rawProduct))->resolve() : null;
//         return $rawProduct;
//        return $product;

        $rawRelatedProducts =  $productServ->getRelatedProducts($product['category_id'], $product['product_id'], $lang);
//        return $rawRelatedProducts;
        $relatedProducts = ProductResource::collection($rawRelatedProducts)->resolve();
//        return $relatedProducts;

//        $relatedProducts = Product::RelatedProducts($product->category_id, $product->product_id, $lang)->get();
        $customer = Auth::guard('customers')->user();
//        $cartCount = $customer ? CartItem::where('customer_id', $customer->id)->sum('quantity') :  (session()->has('cart') ? array_sum(session('cart')) : 0);
        $cartCount = $cartItemServ->getCartCount($customer->id?? null);
//        $end = microtime(true);
//        $durationInMs = ($end - $start) * 1000;
//        dd($durationInMs . ' ms');

        return view('front.product', compact('categories', 'lang', 'product', 'relatedProducts', 'cartCount', 'languages'));
    }






//    public function sort(Request $request, ProductService $productServ){
//        try{
//            $lang = get_active_lang();
//            $sortType = $request->input('sortType');
//
//            $result = $productServ->getSortedProducts($lang, $sortType);
//            $products = ProductResource::collection($result?? collect([]))->resolve();
////            return response()->json($result);
//            return response()->json([
//                'status'    => 'success',
//                'products'   => $products,
//            ]);
//
//        }catch(\Exception $e){
//            // If the service throws a stock error, grab it here gracefully
//            return response()->json([
//                'status'  => 'error',
//                'message' => $e->getMessage(),
//            ], 422);
//        }
//
//    }


    public function filter(Request $request, ProductService $productServ){
        try{
            $lang = get_active_lang();
            $attrValIds = $request->input('attrValIds', []);
            $sortType = $request->input('sortType');

            [$rawProducts, $valuesCounts] = $productServ->getFilteredProducts($lang, $attrValIds, $sortType);
            $products = ProductResource::collection($rawProducts?? collect([]))->resolve();
//            return response()->json($result);

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
