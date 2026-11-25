<?php

namespace App\Services\Front;

use App\Repositories\Front\AttributeRepository;
use App\Repositories\Front\BrandRepository;
use App\Repositories\Front\CategoryRepository;
use App\Repositories\Front\ProductRepository;
use App\Services\Front\PriceCalculationService;



class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepo,
                                protected ProductRepository $productRepo,
                                protected AttributeRepository $attributeRepo,
                                protected PriceCalculationService $priceCalcServ,
    ) {}




    public function getHomeCategories($lang)
    {
        return $this->categoryRepo->getHomeCategories($lang);
    }

    public function getLoadCategoryTranslationsRelations($categoryTranslation)
    {
        return $this->categoryRepo->getLoadCategoryTranslationsRelations($categoryTranslation);
    }


//    public function getSortedCategories($lang, $categoryId, $sortType){
//        $category = $this->categoryRepo->getCheckCategoryExist($categoryId);
//        if($category){
//            if((string) $sortType && in_array($sortType, ['popular', 'new', 'low', 'high'])) {
//                if ($sortType === 'popular') {
//                    $products = $this->productRepo->getTopSellingProducts($lang, null, $categoryId);
//                }
//                elseif ($sortType === 'new') {
//                    $products = $this->productRepo->getNewArrivalProducts($lang, null, $categoryId);
//                }
//                elseif ($sortType === 'low' || $sortType === 'high') {
//                    $products = $this->productRepo->getHomeProducts($lang, null, null, $categoryId, $sortType);
//                }
//            }
//            else{throw new \Exception('no such filter exist');}
//
//            if(!$products || $products->isEmpty() ) {return null;}
//            else{
//                $products = $this->priceCalcServ->getPriceRules_Discounts($products);
//                return $products;
//            }
//
//        }else{
//            throw new \Exception('no such Category exist');
//        }
//    }


    public function getFilteredCategories($lang, $categoryId, $attrValIds, $sortType){
        $category = $this->categoryRepo->getCheckCategoryExist($categoryId);
        $idsCount = count($attrValIds);
        if($idsCount > 0) { $attributeValues = $this->attributeRepo->getCheckExist($attrValIds); }
        if(!$sortType) { $sortType = 'default'; }

        if($category){
            if($idsCount === 0 || $attributeValues) {
                  $products = $this->productRepo->getFilteredProducts($lang, null, $categoryId, $attrValIds, $sortType);
                  if($products || $products->isNotEmpty()){
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
