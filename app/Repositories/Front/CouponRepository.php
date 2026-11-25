<?php

namespace App\Repositories\Front;

use App\Models\Coupon;
use Illuminate\Contracts\Database\Eloquent\Builder;


class CouponRepository
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

    protected function getOneSpecificCoupon($query, $code) {
        return $query
            ->where('is_active', 1)
            ->where('code', $code)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
                     ->select('id', 'code');
    }



/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
//    public function getCoupons(){
//        $query = Coupon::query();
//        $query = $this->getCoupon($query);
//        return $query->get();
//
//    }

    public function getOneCoupon($code){
        $query = Coupon::query();
        $query = $this->getOneSpecificCoupon($query, $code);
        return $query->first();
    }


}
