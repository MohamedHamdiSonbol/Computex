<?php

namespace App\Services\Front;

use App\Http\Resources\Front\CustomerResource;
use App\Repositories\Front\CouponRepository;
use App\Repositories\Front\OrderRepository;
use \App\Services\Front\CustomerService;
use \App\Services\Front\CartItemService;
use Illuminate\Support\Facades\DB;


class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepo,
        protected CustomerService $customerServ,
        protected CartItemService $cartItemServ,
        protected CouponRepository $couponRepo,

    ) {}

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/


/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getOrderData($orderNumber, $customerId, $lang){
        $order = $this->orderRepo->getOrderData($orderNumber, $customerId);
        $orderItems = $this->orderRepo->getOrderItems($order, $lang);
        $orderItems=  $orderItems->map(function ($item) {
             return [
                 'product_id' => $item->product_id,
                 'quantity'   => $item->quantity,
                 'price'      => $item->price,
                 'color'      => $item->color->color_name,
                 'photo'      => asset('assets/admin/images/products/' . $item->product->photo),
                 'name'       => $item->product->translation->name,
             ];
         });

        return [$order, $orderItems] ;
    }




    public function placeOrder($customer, string $lang)
    {
        if (!$customer) {
            throw new \Exception("Guest checkout not supported yet.");
        }

        // Database transactions belong in the service layer where the business logic lives
        return DB::transaction(function () use ($customer, $lang) {

            // 1. Gather Customer Data
            $customerRawData  = $this->customerServ->getCustomerData($customer->id, $lang);
            if (!$customerRawData) {
                throw new \Exception("Customer details could not be retrieved.");
            }
            $customerData = (new CustomerResource($customerRawData))->resolve();

            // 2. Gather Cart Data & Totals
            [$cartItems, $couponData, $cartTotal] = $this->cartItemServ->getCustomerProducts($customer->id, $lang);
            if (!$cartItems || $cartItems->isEmpty() || !$cartTotal) {
                throw new \Exception("Your cart is empty.");
            }

            $orderTotal = $this->cartItemServ->getOrderTotalPrice($cartTotal, $couponData, $shipping=50, $fees=20, $customer->id, $lang);

            $couponId = null;
            if(!empty($couponData) && isset($couponData['couponName'])){
                $coupon = $this->couponRepo->getOneCoupon($couponData['couponName']);
                $couponId = $coupon->id;
            }

            // 3. Transform cart products to array format for database insertion
            $orderItems = $cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'color_id'   => $item->color_id,
                    'quantity'   => $item->quantity_in_cart,
                    'price'      => $item->final_price,
                ];
            })->toArray();
//            return $cartItems;

            // 4. Create Main Order Row
            $order = $this->orderRepo->createOrder(
                $customer->id,
                $couponId,
                $customerData['first_name'] . ' ' . $customerData['last_name'],
                $customerData['mobile'],
                $customerData['address'],
                $shipping,
                $fees,
                $orderTotal
            );

//            return $order;
            // 5. Create Many Order Items attached to that order
             $this->orderRepo->createOrderItems($order, $orderItems);


            // 6. Post-Order Side Effect: Clear the user's cart
            $this->customerServ->truncateCart($customer);

            // Remove coupon used by this user from session
            if($couponData){
                $couponSession = session()->get('coupon');
                $key = $customer->id.'_'.$couponData['couponName'];
                if($couponSession){
                    if(in_array($key, array_keys($couponSession)) ){
                        unset($couponSession[$key]);
                    }
                }
            }


            // Return the finished order back to the controller
            return $order;
        });
    }











}
