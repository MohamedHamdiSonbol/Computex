<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UpdatePasswordRequest;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\CustomerResource;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\CustomerService;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryService $categoryServ, CartItemService $cartItemServ, CustomerService $customerServ)
    {
//        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
//        return $categories;

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

        $customerRawData = $customerServ->getCustomerData($customer->id, $lang);
        $customerData = $customerRawData ? (new CustomerResource($customerRawData))->resolve() : null;
//        return $customerData;

//        $end = microtime(true);
//        dd($end - $start);

        return view('front.customers.index', compact('lang', 'categories','cartCount', 'customerData', 'languages'));
    }

    public function security(CategoryService $categoryServ, CartItemService $cartItemServ){
        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

        return view('front.customers.security', compact('lang', 'categories','cartCount', 'languages'));
    }


    public function orders(CategoryService $categoryServ, CartItemService $cartItemServ){
        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);


        $orders = $customer->orders()->select(['id', 'order_number', 'total_price', 'status'])->get();
//      return $orders;
        return view('front.customers.orders', compact('lang', 'categories', 'languages', 'cartCount', 'orders'));

    }


    public function updatePassword(UpdatePasswordRequest $request, CategoryService $categoryServ, CartItemService $cartItemServ, CustomerService $customerServ){
        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $customerServ->changePassword($customer, $request->password);

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

        return view('front.customers.security', compact('lang', 'categories', 'languages','cartCount'));
    }



}
