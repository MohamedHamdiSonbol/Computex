<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\ProductResource;
use App\Services\Front\AttributeService;
use App\Services\Front\ProductService;
use App\Services\Front\SearchService;
use Illuminate\Http\Request;


class SearchController extends Controller
{


    public function fetchMatchedProducts(Request $request, ProductService $productServ,  ){
        try{
            $lang = get_active_lang();
            $searchQuery = $request->input('searchTerm');
            $categoryId = $request->input('categoryId'); // e.g., from a dropdown or URL parameter



            $rawProducts = $productServ->getSearchResults($searchQuery, $categoryId);
            $products = ProductResource::collection($rawProducts)->resolve();

//            $products = Product::withTranslation($lang)
//                ->withCategoryName($lang)
//                ->search($searchQuery, $categoryId)
//                ->get();

//            $products = Product::search($searchQuery, $categoryId)
//                ->get();

            return response()->json($products);

        } catch (\Exception $ex){
            return response()->json(['success' => false], 500);
        }
    }



}
