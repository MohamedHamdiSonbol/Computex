<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Color;
use App\Models\Discount;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Queries Components
 |======================================================================================================================
*/

//    public function __construct()
//    {
//        // Start the query on the Product model
//        $this->query = Product::query();
//    }

    // Get Products With Names
    protected function WithTranslation($query, $lang)
    {
        return  $query->where('products.active', 1)
                      ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
                      ->join('languages', function($join) use ($lang) {
                            $join->on('product_translations.language_id', '=', 'languages.id')
                                 ->where('languages.abbr', $lang);
                        })
                ->select('products.id', 'products.photo', 'products.price', 'products.quantity', 'products.active', 'products.created_at', 'products.brand_id','product_translations.name as product_name',  'product_translations.slug');
    }

    // Get Categories With Names
    protected function WithCategoryName($query)
    {
        return  $query->join('category_translations', function ($join) {
            $join->on('category_translations.category_id', '=', 'products.category_id')
                ->on('category_translations.language_id', '=', 'product_translations.language_id');
        })
            ->addSelect( 'category_translations.name as category_name', 'category_translations.slug as category_slug');
    }

    // Get Brand With Names
    protected function WithBrandName($query)
    {
        return $query->join('brand_translations', function ($join) {
            $join->on('brand_translations.brand_id', '=', 'products.brand_id')
                ->on('brand_translations.language_id', '=', 'product_translations.language_id');
        })
            ->addSelect( 'brand_translations.name as brand_name');
    }


    // Filter With Attribute Values
    protected function FilterWithAttributeValues($query, $attrValIds){
        if (empty($attrValIds)) {
            return $query;
        }
        foreach ($attrValIds as $attrValId) {
            $query->whereHas('attributeValues', function ($q) use ($attrValId) {
                $q->where('attribute_value_id', $attrValId);
            });
        }
        return $query;
    }


    // Get Attributes Values
    protected function WithAttributeValues($query, $lang)
    {
        $languageId = Language::where('abbr', $lang)->value('id');
        return  $query->with(['attributeValues:id',
                              'attributeValues.translation' => fn($q) => $q->where("language_id", $languageId)->select('attribute_value_id', 'value')]);

//        return $query
//            ->join('attribute_values', 'product_attribute_values.attribute_value_id', '=', 'attribute_values.id')
//            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
//            ->where('attributes.active', 1)
//
//            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
//            ->where('attribute_translations.language_id', $languageId)
//
//            ->join('attribute_value_translations', 'attribute_values.id', '=', 'attribute_value_translations.attribute_value_id')
//            ->where('attribute_value_translations.language_id', $languageId)
//
//            // Group by the key identifiers so SQL combines the duplicates
//            ->groupBy(
//                'products.id',
//                'brand_name',
//                'category_name',
//                'attributes.id',
//                'attribute_translations.name',
//                'attribute_values.id',
//                'attribute_value_translations.value'
//            )
//
//            ->addSelect(
//                'attributes.id as attribute_id',
//                'attribute_translations.name as attribute_name',
//                'attribute_values.id as attr_val_id as attr_val_id',
//                'attribute_value_translations.value as attr_val_value',
//                \DB::raw('COUNT(product_attribute_values.id) as product_count') // Adjust primary key if needed
//            );


    }


    // Get Colors
    protected function WithColors($query)
    {
        return  $query->with(['colors' => fn($q) =>$q->select('colors.name')]);
    }

    // Get One Product Using Specific ID
    protected function WithOneProduct($query, $productId) {
        return $query->where('id', $productId)->select('id', 'price', 'created_at', 'brand_id', 'category_id');
    }

    // Get Campaign With Names
    protected function WithCampaignName($query)
    {
        return $query->join('campaigns', function ($join) {
            $join->on('campaigns.campaignable_id', '=', 'products.id')
                 ->where('campaigns.campaignable_type', '=', 'product')  // Correctly link the morph relationship
                 ->where('campaigns.is_active', '=', 1);
        })
            ->join('campaign_translations', function ($join) {
                $join->on('campaign_translations.campaign_id', '=', 'campaigns.id')
                    ->on('campaign_translations.language_id', '=', 'product_translations.language_id');
            })
            ->addSelect('campaigns.id as campaign_id', 'campaign_translations.name as campaign_name');
    }

    // Get Products Of One(specific) Category
    protected function WithProductsOfOneCategory($query, $categoryId, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereHas('category', fn($q) => $q->where('id', $categoryId));
    }

    // Get Products Of One(specific) Brand
    protected function WithProductsOfOneBrand($query, $brandId, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereHas('brand', fn($q) => $q->where('id', $brandId));
    }

    // Get Related Products
    protected function WithRelatedProducts($query, $categoryId, $productId){
        return $query->where('products.category_id', '=', $categoryId)
            ->where('products.id', '!=', $productId)
            ->limit(6);
//            ->addSelect('id', 'price', 'photo');
    }

    // Get Top Selling Product For The Past Month
    protected function WithTopSelling($query){
        return $query
            ->addSelect('products.id',  DB::raw('SUM(order_items.quantity) as total_qty'))
            // 1. Join order_items to products first
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            // 2. Join orders to order_items to filter by status/date
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', '=', 'delivered')
                    ->where('orders.created_at', '>=', now()->subDays(30));
            })
            ->groupBy('products.id', 'brand_name', 'category_name')
            ->orderByDesc('total_qty');
    }

// Add New Label For New Arrival Products For The Past Month
//    protected function AddNewArrivals($query)
//    {
//        return $query->selectRaw(
//            'products.*, CASE WHEN products.created_at >= ? THEN 1 ELSE 0 END as new_arrival_label',
//            [now()->subDays(60)->toDateTimeString()]
//        );
//    }

    // Get Newest Products For The Past Month
    protected function WithNewArrivals($query){
        return $query->where('products.created_at', '>=', now()->subDays(80));
    }

    protected function WithBiggestDiscount($query)
    {
        return $query->join('discounts', function ($join) {
            $join->on('discounts.discountable_id', '=', 'campaigns.id')
                 ->where('discounts.discountable_type', 'campaign');
        })
            ->addSelect(DB::raw('
            ROUND( CASE
                WHEN discounts.type = "percentage" THEN discounts.value
                WHEN discounts.type = "fixed" AND products.price > 0
                     THEN (discounts.value / products.price ) * 100
                ELSE 0
            END ) as effective_percentage
        '), 'discounts.type', 'discounts.value')
            // Sort by the highest percentage found
            ->orderByDesc('effective_percentage');
    }

    protected function Search($query, $search, $categoryId)
    {
        return $query
            ->where('products.active', 1)
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->when($search, fn($q) => $q->where('product_translations.name', 'LIKE', '%' . $search . '%'))
            ->when($categoryId !== null && $categoryId !== '', fn($q2) => $q2->where('products.category_id', $categoryId));
    }

    protected function WithLoadProductTranslationsRelations(ProductTranslation $productTranslation, $lang)
    {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $productTranslation->load(['product',
            'product.category:id',
            'product.category.translation' => fn($q) => $q->where('language_id', $languageId)->select('category_id', 'name'),
            'product.brand:id',
            'product.brand.translation' => fn($q) => $q->where('language_id', $languageId)->select('brand_id', 'name'),
            'product.colors:id,name',
            'product.attributeValues:id,attribute_id',
            'product.attributeValues.attribute:id',
            'product.attributeValues.attribute.translation' => fn($q) => $q->where('language_id', $languageId)->select('attribute_id', 'name'),
            'product.attributeValues.translation' => fn($q) => $q->where('language_id', $languageId)->select('attribute_value_id', 'value'),
            ]);
    }

/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/
    public function getAllProductsIds(){
        $query = Product::query();
        return $query->get()->pluck('id');
    }

    public function getAllColorsIds($productId, $colorId){
        $query = Product::query();
         $query = $query->where('id', $productId)
                 ->whereHas('colors', function ($query) use ($colorId) {
                     $query->where('color_id', $colorId);
                 })
                 ->with(['colors' => function ($query) use ($colorId) {
                     $query->where('color_id', $colorId);
                 }]);
        return $query->first();
    }

    public function getHomeProducts($lang, $limit = 12,  $brandId= null, $categoryId= null, $sortType= null){
        $query = Product::query();
        if ($brandId) {$query->where('products.brand_id', $brandId);}
        if ($categoryId) {$query->where('products.category_id', $categoryId);}

        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->WithAttributeValues($query, $lang);
        $query = $this->WithColors($query);
//        $query = $this->AddNewArrivals($query);
        if( ($brandId || $categoryId) && $sortType === 'low' ){return $query->orderBy('products.price', 'asc')->get();}
        if( ($brandId || $categoryId) && $sortType === 'high' ){return $query->orderBy('products.price', 'desc')->get();}
        if( (!$brandId && !$categoryId) && $sortType === 'low' ){return $query->orderBy('products.price', 'asc')->get();}
        if( (!$brandId && !$categoryId) && $sortType === 'high' ){return $query->orderBy('products.price', 'desc')->get();}
        return $query->get();
    }


    public function getFilteredProducts($lang, $brandId= null, $categoryId= null, $attrValIds = null, $sortType= 'default', $priceMin=null, $priceMax=null){
        $query = Product::query();
        if ($brandId) {$query->where('products.brand_id', $brandId);}
        if ($categoryId) {$query->where('products.category_id', $categoryId);}

        if (!is_null($priceMin)) {$query->where('products.price', '>=', $priceMin);}
        if (!is_null($priceMax)) {$query->where('products.price', '<=', $priceMax);}

        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->FilterWithAttributeValues($query, $attrValIds);
        $query = $this->WithAttributeValues($query, $lang);
        $query = $this->WithColors($query);
//        $query = $this->WithNewArrivals($query);
        if($sortType === 'low' ){return $query->orderBy('products.price', 'asc')->get();}
        if($sortType === 'high' ){return $query->orderBy('products.price', 'desc')->get();}
//        if( (!$brandId && !$categoryId) && $sortType === 'low' ){return $query->orderBy('products.price', 'asc')->get();}
//        if( (!$brandId && !$categoryId) && $sortType === 'high' ){return $query->orderBy('products.price', 'desc')->get();}
        if($sortType === 'popular'){$query = $this->WithTopSelling($query);}
       if($sortType === 'new'){ return $query->latest()->get();}
        return $query->get();
    }

    public function getBiggestDiscountProduct($lang){
        $query = Product::query();
        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->WithCampaignName($query);
        $query = $this->WithBiggestDiscount($query);

        return $query->first();
    }

    public function getTopSellingProducts($lang, $brandId= null, $categoryId= null){
        $query = Product::query();
        if ($brandId) {$query->where('products.brand_id', $brandId);}
        if ($categoryId) {$query->where('products.category_id', $categoryId);}

        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->WithTopSelling($query);
        return $query->get();
    }

    public function getTopSellingProduct($lang){
        $query = Product::query();
        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->WithTopSelling($query);
        return $query->first();
    }


    public function getProductsOfOneCategory($id, $lang, $limit = 4){
        $query = Product::query();
        $query = $this->WithProductsOfOneCategory($query, $id, $lang);
        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithBrandName($query);
//        $query = $this->WithNewArrivals($query);

        return $query->paginate($limit);

    }

    public function getProductsOfOneBrand($id, $lang, $limit = 4){
        $query = Product::query();
        $query = $this->WithProductsOfOneBrand($query, $id, $lang);
        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithBrandName($query);
        $query = $this->WithCategoryName($query);
        $query = $this->WithColors($query);
//        $query = $this->WithNewArrivals($query);

        return $query->paginate($limit);

    }

    public function getLoadProductTranslationsRelations($productTranslation, $lang){
        $loadedModel = $this->WithLoadProductTranslationsRelations($productTranslation, $lang);
        $isNewArrival = $loadedModel->product->created_at >= now()->subDays(30);
        $loadedModel->new_arrival_label = $isNewArrival ? 'New' : '';
        return $loadedModel;
    }

    public function getRelatedProducts($categoryId, $productId, $lang){
        $query = Product::query();
        $query = $this->WithRelatedProducts($query, $categoryId, $productId);
        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithBrandName($query);

        return $query->get();
    }

    public function getOneProductData($productId) {
        $query = Product::query();
        $query = $this->WithOneProduct($query, $productId);
        return  $query->first();
    }

    public function getNewArrivalProducts($lang, $brandId = null, $categoryId = null){
        $query = Product::query();
        if ($brandId) {$query->where('products.brand_id', $brandId);}
        if ($categoryId) {$query->where('products.category_id', $categoryId);}

        $query = $this->WithTranslation($query, $lang);
        $query = $this->WithCategoryName($query);
        $query = $this->WithBrandName($query);
        $query = $this->WithColors($query);
//        $query = $this->WithNewArrivals($query);
        return $query->latest()->get();
    }

    public function searchForProducts($search, $categoryId ){
        $query = Product::query();
        $query = $this->Search($query, $search, $categoryId );
        return $query->paginate(12);
    }



}
