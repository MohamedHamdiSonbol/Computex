<?php

namespace App\Services\Front;

use App\Repositories\Front\AttributeRepository;
use App\Repositories\Front\DiscountRepository;
use App\Repositories\Front\ProductRepository;
use \App\Services\Front\PriceCalculationService;


class ProductService
{
    public function __construct(
        protected ProductRepository $productRepo,
        protected DiscountRepository $discountRepo,
        protected PriceCalculationService  $priceCalcServ,
        protected AttributeRepository $attributeRepo,
    ) {}

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

    public function getHomeProductsWithDiscounts($lang)
    {
        $products = $this->productRepo->getHomeProducts($lang);
        return $products;
        if(!$products) return null;
        return $this->priceCalcServ->getPriceRules_Discounts($products);

//        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts(); // One query for all discounts
//
//        return $products->map(function ($product) use ($campaigns) {
//            // Find the best discount for THIS specific product from the collection in memory
//            $bestDiscount = $campaigns->first(function ($c) use ($product) {
//                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->id) ||
//                       ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                       ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                       is_null($c->campaignable_type); // Storewide fallback
//            });
//
//            $product->discount_details = $this->discountAmount($product, $bestDiscount);
//            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//
//            return $product;
//        });
    }

    public function getRelatedProducts($categoryId, $productId, $lang)
    {
        $products = $this->productRepo->getRelatedProducts($categoryId, $productId, $lang);
        return $this->priceCalcServ->getPriceRules_Discounts($products);

//        return $products;
//        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts(); // One query for all discounts
//
//        return $products->map(function ($product) use ($campaigns) {
//            // Find the best discount for THIS specific product from the collection in memory
//            $bestDiscount = $campaigns->first(function ($c) use ($product) {
//                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->id) ||
//                       ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                       ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                       is_null($c->campaignable_type); // Storewide fallback
//            });
//
//            $product->discount_details = $this->discountAmount($product, $bestDiscount);
//            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//
//            return $product;
//        });
    }

    public function getBiggestDiscountProduct($lang)
    {
        $product =  $this->productRepo->getBiggestDiscountProduct($lang);
        if(!$product) return null;
        return $this->priceCalcServ->getPriceRules_Discounts($product);

//        $product->discount_details = $this->discountAmount($product, $product);
//        $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//        return $product;
    }

    public function getTopSellingProducts($lang)
    {
        $products =  $this->productRepo->getTopSellingProducts($lang);
        return $this->priceCalcServ->getPriceRules_Discounts($products);

//        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts(); // One query for all discounts
//
//        return $products->map(function ($product) use ($campaigns) {
//            // Find the best discount for THIS specific product from the collection in memory
//            $bestDiscount = $campaigns->first(function ($c) use ($product) {
//                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->id) ||
//                    ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                    ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                    is_null($c->campaignable_type); // Storewide fallback
//            });
//
//            $product->discount_details = $this->discountAmount($product, $bestDiscount);
//            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//
//            return $product;
//        });
    }

    public function getTopSellingProduct($lang)
    {
        $product =  $this->productRepo->getTopSellingProduct($lang);
//        $product->discount_details = $this->discountAmount($product, $product);
//        $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
        return $product;
    }

    public function getNewArrivalProduct($lang)
    {
        $products =  $this->productRepo->getNewArrivalProducts($lang);
//        return $products;
        return $this->priceCalcServ->getPriceRules_Discounts($products);
//                dd([
//            'Type of Variable' => gettype($products),
//            'Is it a Collection?' => $products instanceof \Illuminate\Support\Collection ? 'Yes' : 'No',
//            'Raw Data Dump' => $products
//        ]);


        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts(); // One query for all discounts

        return $products->map(function ($product) use ($campaigns) {
            // Find the best discount for THIS specific product from the collection in memory
            $bestDiscount = $campaigns->first(function ($c) use ($product) {
                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->id) ||
                    ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
                    ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
                    is_null($c->campaignable_type); // Storewide fallback
            });

            $product->discount_details = $this->discountAmount($product, $bestDiscount);
            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);

            return $product;
        });
    }

    public function getProductsOfOneCategory($id, $lang)
    {
        $products = $this->productRepo->getProductsOfOneCategory($id, $lang);
        return $this->priceCalcServ->getPriceRules_Discounts($products);
    }

    public function getProductsOfOneBrand($id, $lang)
    {
        $products = $this->productRepo->getProductsOfOneBrand($id, $lang);
        $products =  $this->priceCalcServ->getPriceRules_Discounts($products);
        $cleanPrices = $products->map(function ($product) {
            return (float) str_replace(',', '', $product['price']);
        });

        return [$products, $cleanPrices];
    }

    public function getLoadProductTranslationsRelations($productTranslation, $lang)
    {
        $product = $this->productRepo->getLoadProductTranslationsRelations($productTranslation, $lang);
//        return $product;

        $product =  (object) [
            'product_id'        => $product['product']['id'] ?? null,
            'name'              => $product['name'] ?? null,
            'slug'              => $product['slug'] ?? null,
            'brand_name'        => $product['product']['brand']['translation']['name'] ?? null,
            'category_name'     => $product['product']['category']['translation']['name'] ?? null,
            'description'       => $product['description'] ?? null,
            'photo'             => $product['product']['photo'] ?? null,
            'active'            => $product['product']['active'] ?? null,
            'price'             => $product['product']['price'] ?? null,
            'quantity'          => $product['product']['quantity'] ?? null,
            'brand_id'          => $product['product']['brand_id'] ?? null,
            'category_id'       => $product['product']['category_id'] ?? null,
            'new_arrival_label' => $product['new_arrival_label'] ?? null,
            'attribute_values'  => $product['product']['attributeValues'] ?? null,
            'colors'            => $product['product']['colors'] ?? null,
        ];
//        dd($product);
//        return $product;
        return $this->priceCalcServ->getPriceRules_Discounts($product);

//        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts();
//        // Find the best discount for THIS specific product from the collection in memory
//        $bestDiscount = $campaigns->first(function ($c) use ($product) {
//            return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->product_id) ||
//                ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                is_null($c->campaignable_type); // Storewide fallback
//        });
//        $product->discount_details = $this->discountAmount($product, $bestDiscount);
//        $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//        return $product;
    }

    public function getSearchResults(string $search, $categoryId = null){
        $products = $this->productRepo->searchForProducts($search, $categoryId);
//        return $products;
//        $campaigns = $this->discountRepo->getActiveCampaignsDiscounts(); // One query for all discounts
//
//        return $products->map(function ($product) use ($campaigns) {
//            // Find the best discount for THIS specific product from the collection in memory
//            $bestDiscount = $campaigns->first(function ($c) use ($product) {
//                return ($c->campaignable_type === 'product' && $c->campaignable_id == $product->id) ||
//                    ($c->campaignable_type === 'brand' && $c->campaignable_id == $product->brand_id) ||
//                    ($c->campaignable_type === 'category' && $c->campaignable_id == $product->category_id) ||
//                    is_null($c->campaignable_type); // Storewide fallback
//            });
//
//            $product->discount_details = $this->discountAmount($product, $bestDiscount);
//            $product->final_price = $product->price - ($product->discount_details['amount'] ?? 0);
//
//            return $product;
//        });
//                dd([
//            'Type of Variable' => gettype($products),
//            'Is it a Collection?' => $products instanceof \Illuminate\Support\Collection ? 'Yes' : 'No',
//            'Raw Data Dump' => $products
//        ]);
        return $this->priceCalcServ->getPriceRules_Discounts($products);
    }


    public function getSortedProducts($lang, $sortType){
//        $category = $this->categoryRepo->getCheckCategoryExist($categoryId);
//        if($category){
            if((string) $sortType && in_array($sortType, ['popular', 'new', 'low', 'high'])) {
                if ($sortType === 'popular') {
                    $products = $this->productRepo->getTopSellingProducts($lang);
                }
                elseif ($sortType === 'new') {
                    $products = $this->productRepo->getNewArrivalProducts($lang);
                }
                elseif ($sortType === 'low' || $sortType === 'high') {
                    $products = $this->productRepo->getHomeProducts($lang, null, null, null, $sortType);
                }
            }
            else{throw new \Exception('no such filter exist');}

            if(!$products || $products->isEmpty() ) {return null;}
            else{
                $products = $this->priceCalcServ->getPriceRules_Discounts($products);
                return $products;
            }

//        }else{
//            throw new \Exception('no such Category exist');
//        }
    }


    public function getFilteredProducts($lang, $attrValIds, $sortType){
//        $category = $this->categoryRepo->getCheckCategoryExist($categoryId);
        $idsCount = count($attrValIds);
        if($idsCount > 0) { $attributeValues = $this->attributeRepo->getCheckExist($attrValIds); }
        if(!$sortType) { $sortType = 'default'; }

//        if($category){
        if($idsCount === 0 || $attributeValues) {
            $products = $this->productRepo->getFilteredProducts($lang, null, null, $attrValIds, $sortType);
            if($products){
                $valuesCounts =  $products->pluck('attributeValues')
                    ->collapse() // Flatten all nested attribute array items into one long list
                    ->groupBy('id') // Group by the unique attribute value ID
                    ->map(function ($group) {
                        $first = $group->first();
                        return [
                            'attribute_value_id' => $first->id,
                            'value' => $first->translation->value ?? null,
                            'product_count' => $group->count() // This gives you the active dynamic count!
                        ];
                    })->values();
            }
            if(!$products || $products->isEmpty() ) {return null;}
            else{
                $products = $this->priceCalcServ->getPriceRules_Discounts($products);
                return [$products, $valuesCounts];
            }
        }
//        }
//        else{
//            throw new \Exception('no such Category exist');
//        }
    }







}
