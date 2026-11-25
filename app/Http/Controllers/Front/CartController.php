<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CartItemResource;
use App\Http\Resources\Front\CategoryResource;
use App\Models\Product;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryService $categoryServ, CartItemService $cartItemServ, CouponService  $couponServ)
    {
        $start = microtime(true);
//    return session()->forget('cart');
//    $coupon =  session()->get('coupon');
//    return $coupon;
        $customer = Auth::guard('customers')->user();

        $lang = get_active_lang();
        $languages = get_active_languages();

        $cartCount = $cartItemServ->getCartCount($customer->id?? null);
//        return $cartCount;

//      $show = $couponServ->addCoupon(1, 'en','shit');
//        return $show;

//        $show = $cartItemServ->show($customer);
//         return $show;

        $rawCategories = $categoryServ->getHomeCategories($lang);
        $categories = CategoryResource::collection($rawCategories)->resolve();
//       return $categories;

         [$cartRawProducts , $couponData, $cartGrandTotal] = $cartItemServ->getCustomerProducts($customer->id?? null, $lang);
         $cartProducts = CartItemResource::collection($cartRawProducts ?? [])->resolve();
//         return $cartRawProducts;
//         return $cartProducts;
//         return $couponData;

//         $cartGrandTotal = $cartItemServ->getGrandTotalPrice($customer->id?? null, $lang);
//         $cartGrandTotal = 55;
//         return $cartGrandTotal;

//        $end = microtime(true);
//        $durationInMs = ($end - $start) * 1000;
//        dd($durationInMs . ' ms');

        return view('front.cart', compact('lang', 'categories','cartCount', 'cartProducts', 'cartGrandTotal', 'languages'));
    }

    public function refresh(CartItemService $cartItemServ){
        try {
            $customer = Auth::guard('customers')->user();
            $result = $cartItemServ->getCartCount($customer->id?? null);
//        return response()->json($result);
            return response()->json([
                'status'    => 'success',
                'cartCount' => $result,
            ]);

        } catch (\Exception $e) {
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function add(Request $request, Product $product, CartItemService $cartItemServ) // Removed $Id from here
    {
        $quantity = $request->input('quantity', 1);
        $colorId = $request->input('color_id', null);
        $customer = Auth::guard('customers')->user();
        $lang = get_active_lang();
//        return $colorId;
//        $result = $cartItemServ->addProductToCart($product, $quantity, $colorId,$customer->id?? null, $lang);
//        return response()->json($result);

        try {
            if($quantity <= 0){
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Quantity must be greater than 0',
                ], 422);
            }

            $result = $cartItemServ->addProductToCart($product, $quantity, $colorId,$customer->id?? null, $lang);
//        return response()->json($result);
            return response()->json([
                'status'    => 'success',
                'message'   => $result['message'],
                'cartCount' => $result['cartCount'],

            ]);

        } catch (\Exception $e) {
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

    }

    public function addCoupon(Request $request, CartItemService $cartItemServ, CouponService $couponServ) // Removed $Id from here
    {
        try {
            $couponCode = $request->input('couponVal');
            $customer = Auth::guard('customers')->user();
            $lang = get_active_lang();

            [$cartItems, $couponData, $cartTotal] = $cartItemServ->getCustomerProducts($customer->id?? null, $lang);
            $result = $couponServ->addingCoupon($customer->id?? null, $couponCode,  $cartTotal);
//        return response()->json($result);

            return response()->json([
                'status'    => 'success',
                'couponName' => $result['couponName'],
                'discount'   => $result['discount'],
                'finalTotal' => $result['finalTotal']
            ]);

        } catch (\Exception $e) {
            // This will send the actual error message to your JS console for debugging
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function increase(Request $request, Product $product, CartItemService $cartItemServ)
    {
        $currentUiQuantity = $request->input('quantity');
        $colorId = $request->input('color_id', null);
        $customer = Auth::guard('customers')->user();
        $lang = get_active_lang();
//        $result = $product->colors()->where('color_id', $colorId)->select('quantity')->first()->quantity;
//        return response()->json($result);
        try {
            $result = $cartItemServ->increaseProductQuantity($product, $currentUiQuantity, $colorId, $customer->id?? null, $lang);
//        return response()->json($result);

            return response()->json([
                'status'    => 'success',
                'quant'     => $result['quant'],
                'cartCount' => $result['cartCount'],
                'subTotal'  => $result['subTotal'],
                'cartTotal' => $result['cartTotal'],
            ]);

        } catch (\Exception $e) {
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

    }

    public function decrease(Request $request, Product $product, CartItemService $cartItemServ)
    {
        $currentUiQuantity = $request->input('quantity');
        $colorId = $request->input('color_id', null);
        $customer = Auth::guard('customers')->user();
        $lang = get_active_lang();
//        $result = $product->colors()->where('color_id', $colorId)->select('quantity')->first()->quantity;
//        return response()->json($result);
        try {
            $result = $cartItemServ->decreaseProductQuantity($product, $currentUiQuantity, $colorId,$customer->id?? null, $lang);
//        return response()->json($result);

            return response()->json([
                'status'    => 'success',
                'quant'     => $result['quant'],
                'cartCount' => $result['cartCount'],
                'subTotal'  => $result['subTotal'],
                'cartTotal' => $result['cartTotal'],
            ]);

        } catch (\Exception $e) {
            // If the service throws a stock error, grab it here gracefully
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

    }

    public function destroy(Request $request, Product $product, CartItemService $cartItemServ) // Removed $Id from here
    {
        $lang = get_active_lang();
        $customer = Auth::guard('customers')->user();
        $colorId = $request->input('color_id', null);
        $cart = collect(session()->get('cart'));
//        $cart = $cart->keys();
//        return response()->json($cart);
        try {
            $result = $cartItemServ->removeProduct($product, $colorId,$customer->id ?? null, $lang);

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'cartCount' => $result['cartCount'],
                'cartTotal' => $result['cartTotal'],
                'isCartEmpty'=> $result['cartCount'] === 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


}
