<?php

namespace App\Repositories\Front;

use App\Models\Discount;
use Illuminate\Contracts\Database\Eloquent\Builder;


class DiscountRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/


//    protected function getCoupon($query) {
//        return $query->where('is_active', 1)
//                     ->select('id', 'starts_at', 'ends_at', 'code');
//    }





/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/

    public function getActiveCampaignsDiscounts()
    {
        return Discount::query()
            ->join('campaigns', function ($join) {
                $join->on('discounts.discountable_id', '=', 'campaigns.id')
                    ->where('discounts.discountable_type', 'campaign')
                    ->where('campaigns.is_active', true);
            })
            ->where(fn($q) => $q->whereNull('campaigns.starts_at')->orWhere('campaigns.starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('campaigns.ends_at')->orWhere('campaigns.ends_at', '>=', now()))
            ->orderByDesc('campaigns.priority')
//            ->select('discounts.*', 'campaigns.campaignable_type', 'campaigns.campaignable_id')
            ->select([
//                'discounts.id',               // Explicitly get the Discount ID
                'discounts.*',               // Explicitly get the Discount ID
//                'discounts.type',
//                'discounts.value',
//                'campaigns.campaignable_type', // Who does this apply to? (Product/Brand/Category)
//                'campaigns.campaignable_id',   // The ID of that target
                'campaigns.*'          // To keep track of which one won
//                'campaigns.priority'          // To keep track of which one won
            ])
            ->get(); // Fetch ALL active campaigns into a Collection once
    }




    public function getActiveCouponDiscount($code)
    {
        return Discount::query()
            ->join('coupons', function ($join) use ($code) {
                $join->on('discounts.discountable_id', '=', 'coupons.id')
                    ->where('discounts.discountable_type', 'coupon')
                    ->where('coupons.is_active', true)
                    ->where('coupons.code', $code);
            })
            ->where(fn($q) => $q->whereNull('coupons.starts_at')->orWhere('coupons.starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('coupons.ends_at')->orWhere('coupons.ends_at', '>=', now()))
            ->select([
                'discounts.*',               // Explicitly get the Discount ID
                'coupons.*',          // To keep track of which one won
                'coupons.id as coupon_id',          // To keep track of which one won
            ])
            ->first(); // Fetch ALL active coupons into a Collection once
    }




}
