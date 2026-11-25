<?php

namespace App\Services\Front;

use App\Repositories\Front\DiscountRepository;



class PriceCalculationService
{
    public function __construct(protected DiscountRepository $discountRepo){}

    protected function discountAmount($product, $discount)
    {
        if (!$discount) return null;

        $val = (float) $discount->value;
        $amount = ($discount->type === 'percentage') ? ($product->price * $val) / 100 : $val;

        return [
            'label'  => ($discount->type === 'percentage') ? $val . '%' : round(($val / $product->price) * 100) . '%',
            'amount' => $amount
        ];
    }


    protected function applyDiscountsToSingleProduct($product, $campsDiscounts)
    {
        // Find the best discount for THIS specific product from the collection in memory
        $bestDiscount = $campsDiscounts->first(function ($c) use ($product) {
            return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->product_id) ||
                ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
                ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
                is_null($c->campaignable_type); // Storewide fallback
        });

        // Safe Fallback: Handle items without active campaigns smoothly without breaking
        if (!$bestDiscount) {
            $product->discount_details = ['amount' => 0, 'percentage' => '0%'];
            $product->final_price = $product->price;
            return $product;
        }
        // Handle if We are dealing with Cart products
        if(isset($product->quantity_in_cart)){
            if ($product->quantity_in_cart < $bestDiscount->min_quantity) {
                $product->discount_details = ['amount' => 0, 'percentage' => '0%'];
                $product->final_price = $product->price;
            } else {
                $product->discount_details = $this->discountAmount($product, $bestDiscount);
                $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
            }
            return $product;
        }
        // If we aren't dealing with Cart products
        else {
            $product->discount_details = $this->discountAmount($product, $bestDiscount);
            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
        }

        return $product;
    }


    public function getPriceRules_Discounts($cartProducts)
    {
        $campsDiscounts = $this->discountRepo->getActiveCampaignsDiscounts();

        // 1. If it's a collection or array, loop through each item using map()
        if ($cartProducts instanceof \Illuminate\Support\Collection || is_array($cartProducts)) {
            return collect($cartProducts)->map(function ($product) use ($campsDiscounts) {
                return $this->applyDiscountsToSingleProduct($product, $campsDiscounts);
            });
        }
        elseif ($cartProducts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return $cartProducts->through(function ($product) use ($campsDiscounts){
                return $this->applyDiscountsToSingleProduct($product, $campsDiscounts);
            });
        }
        // 2. If it's a single object, process and return it directly!
        else{
            return $this->applyDiscountsToSingleProduct($cartProducts, $campsDiscounts);
        }
    }


    public function getPriceRules_DiscountForCoupon($cartTotal, $code, $customerId)
    {
        $couponDiscount = $this->discountRepo->getActiveCouponDiscount($code);
//        return $couponDiscount;
        if($cartTotal <= $couponDiscount->min_order_value){
            return $cartTotal;
        }
        if($couponDiscount->type === 'percentage'){
            $discountAmount = ($couponDiscount->value / 100) * $cartTotal;
        }elseif ($couponDiscount->type === 'fixed') {
            $discountAmount = $couponDiscount->value;
        }
        $couponSession = session()->get('coupon');
        $key = $customerId.'_'.$couponDiscount['code'];
        if($couponSession){
            if(in_array($key, array_keys($couponSession)) ){
                $cartTotal -= $discountAmount;
                return [$discountAmount?? 0, $cartTotal];
            }
        }
        else{
            $couponSession = session()->get('coupon', []);
            $couponSession[$key] = [$couponDiscount['coupon_id'] => $couponDiscount['code']];
            session()->put('coupon', $couponSession);
            $cartTotal -= $discountAmount;
//        return $couponSession;
            return [$discountAmount?? 0, $cartTotal];
        }
    }


//    public function getPriceRules_Discounts($cartProducts)
//    {
//        $campsDiscounts = $this->discountRepo->getActiveCampaignsDiscounts();
////         return $campsDiscounts;
//
//        return $cartProducts->map(function ($product) use ($campsDiscounts) {
//            // Find the best discount for THIS specific product from the collection in memory
//            $bestDiscount = $campsDiscounts->first(function ($c) use ($product) {
//                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->product_id) ||
//                    ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                    ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                    is_null($c->campaignable_type); // Storewide fallback
//            });
//
//            // Safe Fallback: Handle items without active campaigns smoothly without breaking
//            if (!$bestDiscount) {
//                $product->discount_details = ['amount' => 0, 'percentage' => '0%'];
//                $product->final_price = $product->price;
//                return $product;
//            }
//
////            return $bestDiscount;
//            if($product->quantity_in_cart < $bestDiscount->min_quantity ){
//                $product->discount_details = ['amount' => 0, 'percentage' => '0%'];
//                $product->final_price = $product->price;
//            }else{
//                $product->discount_details = $this->discountAmount($product, $bestDiscount);
//                $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//            }
//
//            return $product;
//        });
//
//
//    }
}




//protected function WithColors($query)
//{
//    return  $query->leftJoin('product_color', 'product_color.product_id', '=', 'products.id')
//        ->leftJoin('colors', 'product_color.color_id', '=', 'colors.id')
////            ->addSelect(\DB::raw('GROUP_CONCAT(colors.name SEPARATOR ", ")as color_name'))
////            ->addSelect(\DB::raw('GROUP_CONCAT(product_color.quantity SEPARATOR ", ")as color_quantity'))
////            ->groupBy('product_color.quantity');
//        ->addSelect(\DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as color_name'))
//        ->addSelect(\DB::raw('GROUP_CONCAT(product_color.quantity SEPARATOR ", ") as color_quantity'))
//        // DO NOT group by product_color.quantity, group by the product ID
//        ->groupBy('products.id');
//}
//


