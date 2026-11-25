<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CartItemResource;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\CustomerResource;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Language;
use App\Models\Order;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\CustomerService;
use App\Services\Front\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
//     */
    public function index(CategoryService $categoryServ, CartItemService $cartItemServ, CustomerService $customerServ)
    {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();

        $cartRawProducts = $cartItemServ->getCustomerProducts($customer->id?? null, $lang);
        $cartProducts = CartItemResource::collection($cartRawProducts)->resolve();

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

        $cartGrandTotal = $cartItemServ->getGrandTotalPrice($customer->id?? null, $lang);

        $customerRawData = $customerServ->getCustomerData($customer->id, $lang);
        $customerData = $customerRawData ? (new CustomerResource($customerRawData))->resolve() : null;

        return view('front.checkout', compact('lang', 'categories', 'languages', 'cartCount', 'cartProducts', 'cartGrandTotal', 'customerData'));
    }


    /**
     * Display the specified resource.
     */
    public function store(CartItemService $cartItemServ, CustomerService $customerServ, OrderService $orderServ)
    {
        try {
//            return request()->all;
            $lang = get_active_lang();
            $customer = Auth::guard('customers')->user();
            $order = $orderServ->placeOrder($customer, $lang);
//            return $order;
//            return 'good';
            return redirect()->route('front.order.trackOrder', $order->order_number);
        } catch (\Exception $ex){
return $ex->getMessage();
//            return redirect()->route('admin.products.index')->with('error', 'هناك خطأ ما' . $ex->getMessage());
        }
    }



    public function trackOrder($orderNumber, OrderService $orderServ, CategoryService $categoryServ, CartItemService $cartItemServ, CustomerService $customerServ) {
        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        [$order, $orderItems] = $orderServ->getOrderData($orderNumber, $customer->id?? null, $lang);
//      return $order;
//      return $orderItems;

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);

        $customerRawData = $customerServ->getCustomerData($customer->id, $lang);
        $customerData = $customerRawData ? (new CustomerResource($customerRawData))->resolve() : null;

        return view('front.track-order', compact('lang', 'languages', 'categories', 'cartCount', 'customerData', 'order', 'orderItems'));
    }
}
