<?php

namespace App\Services\Front;

use App\Repositories\Front\CouponRepository;
//use App\Services\Front\CartItemService;
use App\Services\Front\PriceCalculationService;
use Illuminate\Support\Facades\Auth;


class CouponService
{
    public function __construct(
        protected CouponRepository $couponRepo,
//        protected CartItemService $cartItemServ,
        protected PriceCalculationService $priceCalcServ,
    ) {}

    public function addingCoupon($customerId, $code, $cartTotal)
    {
        $coupon = $this->couponRepo->getOneCoupon($code);
        if (!$coupon) {
            throw new \Exception("This Coupon is Wrong Or Expired");
        }
         $couponName = $coupon->code;

        if(Auth::guard('customers')->user()){
//            $cartTotal =  $this->cartItemServ->getGrandTotalPrice($customerId, $lang);
            if(!$cartTotal){throw new \Exception("Something went wrong");}
            [$discountAmount, $cartTotal] =  $this->priceCalcServ->getPriceRules_DiscountForCoupon($cartTotal, $code, $customerId);

            return [
                'couponName'  => $couponName?? null,
                'discount'    => $discountAmount?? null,
                'finalTotal'  => $cartTotal?? null,
            ];
        }
        else{throw new \Exception("Authentication Needed");}

//        elseif(session()->has('cart')){
//            $cartTotal =  $this->cartItemServ->getGrandTotalPrice(null, $lang);
//            if(!$cartTotal){throw new \Exception("Something went wrong");}
//            [$discountAmount, $cartTotal]  =  $this->priceCalcServ->getPriceRules_DiscountForCoupon($cartTotal, $code);
////            $result =  $this->priceCalcServ->getPriceRules_DiscountForCoupon($cartTotal, $code);
////            return $result;
//            return [
//                'couponName'  => $couponName?? null,
//                'discount'    => $discountAmount?? null,
//                'finalTotal'  => $cartTotal?? null,
//            ];
//
//        }
    }



}
