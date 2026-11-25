<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CartItemResource;
use App\Http\Resources\Front\CategoryResource;
use App\Http\Resources\Front\CustomerResource;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryService $categoryServ, CartItemService $cartItemServ, CustomerService $customerServ)
    {
        $start = microtime(true);

        $lang = get_active_lang();
        $languages = get_active_languages();
        $customer = Auth::guard('customers')->user();

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
//        return $categories;

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);
//        return $cartCount;

        [$cartRawProducts , $couponData, $cartGrandTotal] = $cartItemServ->getCustomerProducts($customer->id?? null, $lang);
        $cartProducts = CartItemResource::collection($cartRawProducts ?? [])->resolve();
//        return $cartRawProducts;
//        return $couponData;

        $orderTotalPrice = ceil((ceil($cartGrandTotal ?? 0)) - floor(($couponData['discount'] ?? 0)) + ($shipping ?? 0) + ($fees ?? 0));

        $customerRawData = $customerServ->getCustomerData($customer->id, $lang);
        $customerData = $customerRawData ? (new CustomerResource($customerRawData))->resolve() : null;
//        return $customerData;

//        $end = microtime(true);
//        dd($end - $start);

        return view('front.checkout', compact('lang', 'categories', 'cartCount', 'cartProducts', 'couponData', 'cartGrandTotal', 'orderTotalPrice', 'customerData', 'languages'));
    }


    /**
     * Display the specified resource.
     */
    public function shipping(Request $request, CartItemService $cartItemServ,)
    {
        try {
            $lang = get_active_lang();
            $customer = Auth::guard('customers')->user();
            $shippingValue = (int) $request->input('shippingValue', 1);
            $shippingValue === 1 ? $shipping = 50 : $shipping = 0;
            $result = $cartItemServ->getOrderTotalPrice(null, null, $shipping, null, $customer->id?? null, $lang);
//        return response()->json($shipping);
            return response()->json([
                'status'     => 'success',
                'cartTotal'  => $result['cartTotal'],
                'coupon'     => $result['coupon'],
                'shipping'   => $result['shipping'],
                'fees'       => $result['fees'],
                'orderTotal' => $result['orderTotal'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }



}
