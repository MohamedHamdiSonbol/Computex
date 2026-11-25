<?php

namespace App\Services\Front;

use App\Repositories\Front\AttributeRepository;
use App\Repositories\Front\BrandRepository;
use App\Repositories\Front\ProductRepository;
//use function PHPUnit\Framework\throwException;
use  App\Services\Front\PriceCalculationService;

class BrandService
{
    public function __construct(protected BrandRepository $brandRepo,
                                protected ProductRepository $productRepo,
                                protected AttributeRepository $attributeRepo,
                                protected PriceCalculationService $priceCalcServ,
    ) {}

    public function getHomebrands($lang)
    {
        return $this->brandRepo->getHomebrands($lang);
    }

    public function getLoadBrandTranslationsRelations($brandTranslation)
    {
        return $this->brandRepo->getLoadBrandTranslationsRelations($brandTranslation);
    }


    public function getSortedBrands($lang, $brandId, $sortType){
        $brand = $this->brandRepo->getCheckBrandExist($brandId);
        if($brand){
            if((string) $sortType && in_array($sortType, ['popular', 'new', 'low', 'high'])){
                if($sortType === 'popular'){
                    $products = $this->productRepo->getTopSellingProducts($lang, $brandId, null);
                }
                elseif($sortType === 'new'){
                    $products = $this->productRepo->getNewArrivalProducts($lang, $brandId, null);
                }
                elseif($sortType === 'low' || $sortType === 'high'){
                    $products = $this->productRepo->getHomeProducts($lang, null , $brandId, null, $sortType);
                }
            }
            else{throw new \Exception('no such filter exist');}

            if(!$products || $products->isEmpty() ) {return null;}
            else{
                $products = $this->priceCalcServ->getPriceRules_Discounts($products);
                return $products;
            }

        }else{
            throw new \Exception('no such brand exist');
        }
    }


    public function getFilteredBrands($lang, $brandId, $attrValIds, $sortType, $priceMin, $priceMax){
        $brand = $this->brandRepo->getCheckBrandExist($brandId);
        $idsCount = count($attrValIds);
        if($idsCount > 0) { $attributeValues = $this->attributeRepo->getCheckExist($attrValIds); }
        if(!$sortType) { $sortType = 'default'; }

        if($brand){
            if($idsCount === 0 || $attributeValues) {
                $products = $this->productRepo->getFilteredProducts($lang, $brandId, null, $attrValIds, $sortType, $priceMin, $priceMax);
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

        }else{
            throw new \Exception('no such Category exist');
        }
    }


}
