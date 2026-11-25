<?php

namespace App\Repositories\Front;

use App\Models\Language;
use App\Models\Order;


class OrderRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/


    protected function createOneOrder($query, $customerId, $couponId, $customerName, $mobile, $address, $shipping, $fees, $orderTotal) {
        return $query->create([
            'customer_id'   => $customerId,
            'coupon_id'     => $couponId,
            'customer_name' => $customerName,
            'phone'         => $mobile,
            'address'       => $address,
            'shipping'      => $shipping,
            'fees'          => $fees,
            'total_price'   => $orderTotal, // مؤقتا
            'status'        => 'pending'
        ]);
    }

    protected function orderData($query, $orderNumber, $customerId){
        return $query->where('order_number', $orderNumber)
            ->where('customer_id', $customerId);
    }


/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function createOrder($customerId, $couponId, $customerName, $mobile, $address, $shipping, $fees, $orderTotal){
        $query = Order::query();
        $query = $this->createOneOrder($query, $customerId, $couponId, $customerName, $mobile, $address, $shipping, $fees, $orderTotal);
        return $query;
    }

    public function createOrderItems(Order $order, $orderItems){
        return $order->items()->createMany($orderItems);
    }


    public function getOrderData($orderNumber, $customerId){
        $query = Order::query();
        $query = $this->orderData($query, $orderNumber, $customerId);
        return $query->first();
    }

    public function getOrderItems($order, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $order->items()
            ->with([
                'color',
                'product' => fn($q) => $q->select('id', 'photo', 'created_at'),
                'product.translation' => fn($q) => $q
                    ->where('language_id', $languageId)
                    ->select('product_id', 'name')
            ])
            ->get();
    }

}
