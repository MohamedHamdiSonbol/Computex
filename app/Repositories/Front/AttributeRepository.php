<?php

namespace App\Repositories\Front;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Language;


class AttributeRepository
{
    // We create a property to hold the query as we build it
    protected $query;

/*
 |======================================================================================================================
 | 🔍 Hidden Queries
 |======================================================================================================================
*/

    protected function checkExistance($query, $attrValIds){
        return $query->whereHas('values', function ($q) use ($attrValIds) {
            $q->whereIn('id', $attrValIds);
        });
    }


    protected function withNamesAndValuesTranslation($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('attributes.active', 1)
            ->join('attribute_translations', 'attributes.id', '=', 'attribute_translations.attribute_id')
            ->where('attribute_translations.language_id', $languageId)

            ->join('attribute_values', 'attributes.id', '=', 'attribute_values.attribute_id')

            ->join('attribute_value_translations', 'attribute_values.id', '=', 'attribute_value_translations.attribute_value_id')
            ->where('attribute_value_translations.language_id', $languageId)

            ->join('product_attribute_values', 'attribute_values.id', '=', 'product_attribute_values.attribute_value_id')

            ->join('products', 'product_attribute_values.product_id', '=', 'products.id')

//            ->join('brands', 'products.brand_id', '=', 'brands.id')
//            ->where('brands.id', 1)


            // Group by the key identifiers so SQL combines the duplicates
            ->groupBy(
                'attributes.id',
                'attribute_translations.name',
                'attribute_values.id',
                'attribute_value_translations.value',
            )

            ->select('attributes.id',
               'attribute_translations.name',
                'attribute_values.id as attr_val_id',
               'attribute_value_translations.value',
                \DB::raw('COUNT(product_attribute_values.id) as product_count') // Adjust primary key if needed
            );
    }

protected function withAddBrandsFilter($query, $brandId){
        return $query->join('brands', 'products.brand_id', '=', 'brands.id')
                    ->where('brands.id', $brandId)
                    ->groupBy('brands.id')
                    ->addSelect('brands.id as brand_id');
}

protected function withAddCategoriesFilter($query, $categoryId){
        return $query->join('categories', 'products.category_id', '=', 'categories.id')
                    ->where('categories.id', $categoryId)
                    ->groupBy('categories.id')
                    ->addSelect('categories.id as category_id');
}
/*
 |======================================================================================================================
 | 🔍 Main Queries
 |======================================================================================================================
*/

    public function getCheckExist($attrValIds){
        $query = Attribute::query();
        $query = $this->checkExistance($query, $attrValIds);
        return $query->exists();
    }

    public function getAttributesNamesAndValues($lang, $brandId=null, $categoryId=null){
        $query = Attribute::query();
        $query = $this->withNamesAndValuesTranslation($query, $lang);

        if($brandId){$query = $this->withAddBrandsFilter($query, $brandId);}
        elseif($categoryId){$query = $this->withAddCategoriesFilter($query, $categoryId);}
        return $query->get();
    }

}
