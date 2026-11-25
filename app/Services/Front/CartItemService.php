<?php

namespace App\Services\Front;

//use App\Models\CartItem;
//use App\Models\Product;
use App\Repositories\Front\CartItemRepository;
use App\Repositories\Front\ProductRepository;
use App\Services\Front\CouponService;
use App\Services\Front\PriceCalculationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class CartItemService
{
    public function __construct(
        protected CartItemRepository $cartItemRepo,
        protected ProductRepository $productRepo,
        protected PriceCalculationService $priceCalcServ,
        protected CouponService $couponServ,
    ) {}

    protected function arrangeCartProducts($cartProducts, $cart, $key=null) {
//        dd([
//            'Type of Variable' => gettype($cartProducts),
//            'Is it a Collection?' => $cartProducts instanceof \Illuminate\Support\Collection ? 'Yes' : 'No',
//            'Raw Data Dump' => $cartProducts
//        ]);

        // 1. If it's a single object, wrap it into a temporary Collection
//        $isSingleObject = !($cartProducts instanceof \Illuminate\Support\Collection) && !is_array($cartProducts);
//        if($isSingleObject){
////            $cartProducts = $cartProducts->first();
//            $colorId = $cartProducts->selected_color_id;
//            $sessionKey = $cartProducts->id . '_' . $colorId;
//            return (object) [
//                'product_id'       => $cartProducts->product_id?? $cartProducts->id,
//                'quantity_in_cart' => $cart[$sessionKey]['quantity']?? $cartProducts->quantity,
//                'price'            => $cartProducts->price?? $cartProducts->product->price,
//                'brand_id'         => $cartProducts->brand_id?? $cartProducts->product->brand_id,
//                'category_id'      => $cartProducts->category_id?? $cartProducts->product->category_id,
//                'name'             => $cartProducts->translation->name,
//            ];
//        }

        $cartProducts = $cartProducts->map(function($cartProduct) use ($cart, $key) {
            // Cast this array as an object (stdClass)
            return (object) [
                'product_id'       => $cartProduct->product_id?? $cartProduct->id,   // <== Important
                'photo'            => $cartProduct->photo?? $cartProduct->product->photo?? null,   // <== Important
                'quantity_in_cart' => $cartProduct->quantity_in_cart?? $cart[$key]['quantity'] ?? $cartProduct->quantity,
                'price'            => $cartProduct->price?? $cartProduct->product->price,
                'brand_id'         => $cartProduct->brand_id?? $cartProduct->product->brand_id,
                'category_id'      => $cartProduct->category_id?? $cartProduct->product->category_id,
                'product_name'     => $cartProduct->translation->name?? $cartProduct->product->translation->name?? null,
                'color_id'         => $cartProduct->selected_color_id?? $cartProduct->color_id?? $cartProduct->color->id?? null,
                'color_name'       => $cartProduct->color_name?? $cartProduct->color->color_name??null
            ];
        });

        return $cartProducts;
    }

    protected function checkCustomerAuth(){
        return Auth::guard('customers')->user();
    }

    protected function checkSession(){
       return session()->has('cart');
    }

    protected function getSessionCartCount(){
        return collect(session('cart', []))->sum('quantity');
    }

    protected function getCartProductsFromDBWithPriceCalc($customerId, $lang){
        $cartProducts =  $this->cartItemRepo->getCartProductsFromDB($customerId, $lang);
//         return $cartProducts;
        $cartProducts = $this->arrangeCartProducts($cartProducts, null);
//         return $cartProducts;
        return $this->priceCalcServ->getPriceRules_Discounts($cartProducts);
    }

    protected function getCartProductsFromSessionsWithPriceCalc($productIds, $lang){
        $cartProducts = $this->cartItemRepo->getCartProductsFromSession($productIds, $lang);
//        return $cartProducts;
        $sessionItems = collect(session('cart', []))->map(function($item) {
            $item = $item['quantity'];
            return $item;
        });
//        return $sessionItems;
            foreach($cartProducts as $cartProduct){
                $key = $cartProduct['id'] .'_'. $cartProduct['selected_color_id'];
                $cartProduct['quantity_in_cart'] = $sessionItems[$key] ?? 0;
            }
        $cart = session('cart', []);
//        return $sessionItems;
//        return $cartProducts ;
        $cartProducts =$this->arrangeCartProducts($cartProducts, $cart);
//        return $cartProducts;
        return $this->priceCalcServ->getPriceRules_Discounts($cartProducts);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function show($customer){
//      return $this->mergeGuestCartToDb($customer);
    }


    public function getCartCount($customerId){
        if($this->checkCustomerAuth()){
            return $this->cartItemRepo->getCustomerCartCount($customerId);
        }
        elseif ($this->checkSession()){
            return $this->getSessionCartCount();
        }
        return 0;
    }


    public function removeAllCustomerProductsFromDBCart($customerId){
      return  $this->cartItemRepo->removeAllCustomerProductsFromDBCart($customerId);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public  function mergeGuestCartToDb($customer)
    {
        $cart = session()->get('cart');
        if (empty($cart)) return;
        $result = array_map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'color_id' => $item['color_id']
            ];
        }, $cart);
        $result = array_values($result);

        foreach ($result as $item) {
            // Find existing record in DB
            $cartItem = $this->cartItemRepo->getCartProductFromDB(1, $item['product_id'], $item['color_id']);
            if ($cartItem) {
                $cartItem->increment('quantity', (int)$cart[$cartItem->product_id.'_'.$cartItem->color_id]);
            } else {
                $this->cartItemRepo->createCartItem(1, $item['product_id'], $item['color_id'], (int)$cart[$item['product_id'].'_'.$item['color_id']]);
            }
        }

        // 3. Clear the guest cart so we don't merge it again
        session()->forget('cart');
        session()->forget('coupon');
    }


    public function addProductToCart($product, $requestedQuantity, $colorId, $customerId){
        $product = $this->productRepo->getAllColorsIds($product->id, $colorId);
//      return $product;
        if (!$product || $product->colors->isEmpty()) {
            throw new \Exception("wrong data entered"); // Product or color not found
        }

        $productAllQuantity = $product->quantity;
        $pivotQuantity = $product->colors->first()->pivot->quantity;
        if($requestedQuantity > $pivotQuantity || $requestedQuantity > $productAllQuantity){
            throw new \Exception("The requested quantity is more than the stock quantity");
        }

        if($this->checkCustomerAuth()){
            $cartProduct = $this->cartItemRepo->getOneSpecificProduct($customerId, $product->id, $colorId);
//            return $cartProduct;
            if ($cartProduct->isNotEmpty()) {
                $cartProduct->first()->increment('quantity', $requestedQuantity);
            } else{
                    $this->cartItemRepo->createCartItem($customerId, $product->id, $colorId, $requestedQuantity);
            }
            $cartCount = $this->getCartCount($customerId);
        }

        else{
            $cart = session()->get('cart', []);
            $cartKey = $product->id . '_' . $colorId;
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $requestedQuantity;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $product->id,
                    'quantity'   => $requestedQuantity,
                    'color_id'   => $colorId
                ];
            }
            session()->put('cart', $cart);
            $cartCount = $this->getCartCount($customerId);
        }

        return [
            'message'   => "Product Added successfully!",
            'cartCount' => $cartCount,
        ];
    }


    public function increaseProductQuantity($product, $currentUiQuantity, $colorId, $customerId, $lang){
        if($product->colors()->where('color_id', $colorId)->exists()){
          $colorQuantity = $product->colors()->where('color_id', $colorId)->select('quantity')->first()->quantity;
            if (++$currentUiQuantity > $colorQuantity) {
                throw new \Exception("This quantity is more than what we have in stock (Max: {$colorQuantity})");
            }
        }else{
            throw new \Exception("This Product Or Color not Exists");
        }


//        $cartProductsIds = $this->cartItemRepo->getCustomer($customerId)?->pluck('product_id');

        if($this->checkCustomerAuth()){
            $cartProduct = $this->cartItemRepo->getOneSpecificProduct($customerId, $product->id, $colorId);
//            return $cartProduct;
            if($cartProduct->isEmpty()){throw new \Exception("There is no such product in cart");}
            $cartProduct->first()->increment('quantity', 1);
            $cartProduct = $this->arrangeCartProducts($cartProduct, null);
            $cartProduct = $this->priceCalcServ->getPriceRules_Discounts($cartProduct);
            foreach ($cartProduct as $product) {
                $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
                $itemSubtotal = $product->total_price;
                $newQuantity = $product->quantity_in_cart;
            }
            $cartCount = $this->getCartCount($customerId);
            $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
        }
        elseif ($this->checkSession()){
            $cartProduct = collect([$product]);
//            return $cartProduct;
            $cart = session()->get('cart', []);
            $key = $product->id . '_' . $colorId;
            $newQuantity = ++$cart[$key]['quantity'];
            session()->put('cart', $cart);

            $cartProduct = $this->arrangeCartProducts($cartProduct, $cart, $key);
            $cartProduct = $this->priceCalcServ->getPriceRules_Discounts($cartProduct);
            $cartCount = $this->getCartCount($customerId);
            foreach ($cartProduct as $product) {
                $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
                $itemSubtotal = $product->total_price;
            }
            $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
//            return $cartProduct;
        }

        return [
            'quant'     => $newQuantity,
            'cartCount' => $cartCount,
            'subTotal'  => $itemSubtotal,
            'cartTotal' => $cartTotal,
        ];
    }


    public function decreaseProductQuantity($product, $currentUiQuantity, $colorId, $customerId, $lang){
        if (--$currentUiQuantity < 1) {
            throw new \Exception("This quantity can't be 0 (min: 1)");
        }

        if($product->colors()->where('color_id', $colorId)->exists()){
            $colorQuantity = $product->colors()->where('color_id', $colorId)->select('quantity')->first()->quantity;
            if ($currentUiQuantity > $colorQuantity) {
                throw new \Exception("This quantity is more than what we have in stock (Max: {$colorQuantity})");
            }
        }else{
            throw new \Exception("This Product Or Color not Exists");
        }

        if($this->checkCustomerAuth()){
            $cartProduct = $this->cartItemRepo->getOneSpecificProduct($customerId, $product->id, $colorId);
            if($cartProduct->isEmpty()){throw new \Exception("There is no such product in cart");}

            $cartProduct->first()->decrement('quantity', 1);
            $cartProduct = $this->arrangeCartProducts($cartProduct, null);
            $cartProduct = $this->priceCalcServ->getPriceRules_Discounts($cartProduct);
            foreach ($cartProduct as $product) {
                $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
                $itemSubtotal = $product->total_price;
                $newQuantity = $product->quantity_in_cart;
            }
//            return $cartProduct ;
            $cartCount = $this->getCartCount($customerId);
            $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
        }
        elseif ($this->checkSession()){
            $cartProduct = collect([$product]);
            $cart = session()->get('cart', []);
            $key = $product->id . '_' . $colorId;
            $newQuantity = --$cart[$key]['quantity'];
            session()->put('cart', $cart);
            $cartProduct = $this->arrangeCartProducts($cartProduct, $cart, $key);
            $cartProduct = $this->priceCalcServ->getPriceRules_Discounts($cartProduct);
            foreach ($cartProduct as $product) {
                $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
                $itemSubtotal = $product->total_price;
            }
            $cartCount = $this->getCartCount($customerId);
            $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
        }

        return [
            'quant'     => $newQuantity,
            'cartCount' => $cartCount,
            'subTotal'  => $itemSubtotal,
            'cartTotal' => $cartTotal,
        ];
    }


    public function removeProduct($product, $colorId, $customerId, $lang){
        if($product->colors()->where('color_id', $colorId)->exists() == false){
            throw new \Exception("This Product Or Color not Exists");
        }
//        $cartProductsIds = $this->cartItemRepo->getCustomer($customerId)?->pluck('product_id');
        $cart = session()->get('cart');
//        $cartIds = array_keys($cart);
//
        if($this->checkCustomerAuth()){
            $this->cartItemRepo->removeProductFromDBCart($customerId, $product->id, $colorId);
            $cartCount = $this->getCartCount($customerId);
//            $cartTotal = $this->getGrandTotalPrice($customerId, $lang);
            if (!$cartCount) {
                session()->forget('coupon');
                $cartTotal = 0; // Explicitly set it
            } else {
                $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
            }
        }
        elseif ($this->checkSession()){
            $key = $product->id . '_' . $colorId;
            if(!$cart[$key]){
                throw new \Exception("Wrong Data Entry");
            }
            unset($cart[$key]);
            session()->put('cart', $cart);
            if (count($cart) === 0) session()->forget('cart');
            $cartCount = $this->getCartCount($customerId);
            $cartTotal = $this->getGrandTotalPrice(null, $customerId, $lang);
        }

        return [
            'message'   => "Product deleted successfully!",
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
        ];
    }


    public function getCustomerProducts(?int $customerId, string $lang)
    {
        $cartItems = null;
        if($this->checkCustomerAuth()){
            $coupon = session()->get('coupon');
            if($coupon && !empty($coupon)){
                $pattern = '/^' . $customerId . '_' . '[A-Za-z0-9\-]+$/';
                foreach ($coupon as $key => $value) {
                    if(Str::isMatch($pattern, $key)){$couponValue = $value;}
                }
                if($couponValue){
                    $code = collect($couponValue)->first();
                    $cartItems = $this->getCartProductsFromDBWithPriceCalc($customerId, $lang);
                    if (!$cartItems) {return collect([]);}
                    foreach ($cartItems as $product) {
                        $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
                    };
                    $cartTotal = $this->getGrandTotalPrice($cartItems);
                    $couponData = $this->couponServ->addingCoupon($customerId, $code, $cartTotal);
                    return [$cartItems, $couponData?? null, $cartTotal];
                }
            }
            else{
                $cartItems = $this->getCartProductsFromDBWithPriceCalc($customerId, $lang);
            }
        }

        else if($this->checkSession()){
            $cart = session()->get('cart', []);
            if (count($cart) === 0) { session()->forget('cart');return collect([]); }

            $sessionItems = collect(session('cart'))->values()->map(function($item) {
                $item = [$item['product_id'], $item['color_id']];
                return $item;
            });
              $cartItems =  $this->getCartProductsFromSessionsWithPriceCalc($sessionItems, $lang);
//            return $cartItems;
        }

        if (!$cartItems || $cartItems->isEmpty()) {return [null, null, 0];}
        foreach ($cartItems as $product) {
            $product->total_price = ($product->final_price ?? $product->price) * $product->quantity_in_cart;
        }
        $cartTotal = $this->getGrandTotalPrice($cartItems, $customerId, $lang);

        return [$cartItems, $couponData?? null, $cartTotal];

    }


    public function getGrandTotalPrice($products, $customerId, $lang){
        if($products && $products->isNotEmpty()){
            return  (float) $products->sum('total_price')?? 0.0;
        }
        else{
            [$products, $couponData, $cartTotal] = $this->getCustomerProducts($customerId, $lang);
            return $products->isNotEmpty() ? (float) $products->sum('total_price') : 0.0;
        }
    }


    public function getOrderTotalPrice($cartGrandTotal, $couponData, $shipping, $fees, $customerId, $lang){
        if(!$cartGrandTotal || $cartGrandTotal <= 0){
             [$cartItems, $couponData, $cartGrandTotal] = $this->getCustomerProducts($customerId, $lang);
             $orderTotalPrice = ceil((ceil($cartGrandTotal ?? 0)) - floor(($couponData['discount'] ?? 0)) + ($shipping ?? 0) + ($fees ?? 0));
            return [
                'cartTotal'  => $cartGrandTotal,
                'coupon'     => $couponData,
                'shipping'   => $shipping,
                'fees'       => $fees,
                'orderTotal' => $orderTotalPrice,
            ];
        }
        $orderTotalPrice = ceil((ceil($cartGrandTotal ?? 0)) - floor(($couponData['discount'] ?? 0)) + ($shipping ?? 0) + ($fees ?? 0));
        return $orderTotalPrice;
    }

}
