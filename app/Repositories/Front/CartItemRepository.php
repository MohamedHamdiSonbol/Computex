<?php

namespace App\Repositories\Front;

use App\Models\CartItem;
use App\Models\Language;
use App\Models\Product;


class CartItemRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/
    protected function WithCustomer($query, $customerId) {
        return $query->where('customer_id', $customerId);
    }


    protected function WithOneProductFromDB($query, $productId, $colorId) {
        return $query->where('product_id', $productId)->where('color_id', $colorId)->with(['product' => fn($q) => $q->select('id', 'price', 'created_at', 'brand_id', 'category_id')]);
    }

//    protected function WithOneProductFromDB($query, $productsIds, $colorsIds) {
//        return $query->whereIn('product_id', $productsIds)->whereIn('color_id', $colorsIds)->get();
//    }


//    protected function WithProductsFromDB($query,$lang) {
//        $languageId = Language::where('abbr', $lang)->value('id');
//        return $query->with(['product' => fn($q) => $q->select('id', 'price', 'photo', 'created_at', 'brand_id', 'category_id')
//                ->with(['translation' => fn($q) => $q->where('language_id', $languageId)
//                    ->select('product_id', 'name')])]);
//    }

    protected function WithProductsFromDB($query,$lang) {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->with(['product' => fn($q) => $q->select('id', 'price', 'photo', 'created_at', 'brand_id', 'category_id'),
                             'product.translation' => fn($q) => $q->where('language_id', $languageId)->select('product_id', 'name'),
                             'color' => fn($q) => $q->select('id', 'name as color_name')]);
    }

    protected function WithProductsFromSession($query, $sessionItems, $lang) {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->with(['translation'=> fn($q) => $q->where('language_id', $languageId)->select('product_id', 'name')])
            ->join('product_color', 'products.id', '=', 'product_color.product_id')
            ->join('colors', 'colors.id', '=', 'product_color.color_id')
            ->where(function ($query) use ($sessionItems) {
                foreach ($sessionItems as $item) {
                    [$productId, $colorId] = $item;

                    $query->orWhere(function ($subQuery) use ($productId, $colorId) {
                        $subQuery->where('product_color.product_id', $productId)
                            ->where('product_color.color_id', $colorId);
                    });
                }
            })
            ->select('products.id', 'products.photo', 'products.price', 'products.brand_id', 'products.category_id', 'product_color.color_id as selected_color_id', 'colors.name as color_name');
    }

    protected function create($query, $customerId, $productId, $colorId, $quantity) {
        return $query->create([
            'customer_id' => $customerId,
            'product_id'  => $productId,
            'color_id'    => $colorId,
            'quantity'    => $quantity
        ]);
}

/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function createCartItem($customerId, $productId, $colorId, $quantity){
        $query = CartItem::query();
        $query = $this->create($query, $customerId, $productId, $colorId, $quantity);
        return $query;
    }

    public function getCustomer($customerId){
        $query = CartItem::query();
        $query = $this->WithCustomer($query, $customerId);
        return   $query->get();
    }

    public function getCartProductsFromSession($productIds, $lang){
        $query = Product::query();
        $query = $this->WithProductsFromSession($query, $productIds, $lang);
        return   $query->get();
    }

    public function getCartProductFromDB($customerId, $productId, $colorId){
        $query = CartItem::query();
        $query = $this->WithCustomer($query, $customerId);
        $query = $this->WithOneProductFromDB($query, $productId, $colorId);
        return   $query->first();
    }

    public function getCartProductsFromDB($customerId, $lang){
        $query = CartItem::query();
        $query = $this->WithCustomer($query, $customerId);
        $query = $this->WithProductsFromDB($query, $lang);
        return   $query->get();
    }


    public function getCustomerCartCount($customerId){
        return CartItem::where('customer_id', $customerId)->sum('quantity');
    }

    public function getOneSpecificProduct($customerId, $productId, $colorId) {
        $query = CartItem::query();
        $query = $this->withCustomer($query, $customerId);
        $query = $this->withOneProductFromDB($query, $productId, $colorId);
        $cartItem = $query->get();
        return $cartItem;
    }


    public function removeAllCustomerProductsFromDBCart($customerId) {
        $query = CartItem::query();
        $query = $this->withCustomer($query, $customerId);
        return  $query->delete();
    }


    public function removeProductFromDBCart($customerId, $productId, $colorId) {
        $query = CartItem::query();
        $query = $this->withCustomer($query, $customerId);
        $query = $this->withOneProductFromDB($query, $productId, $colorId);
        return  $query->delete();
    }

}
