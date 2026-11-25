<?php

namespace App\Services\Front;

use App\Repositories\Front\AttributeRepository;



class AttributeService
{
    public function __construct(protected AttributeRepository $attributeRepo) {}

    public function getAttributesNamesAndValues($lang, $brandId, $categoryId){
        $rawAttributes =  $this->attributeRepo->getAttributesNamesAndValues($lang, $brandId, $categoryId);
//return $rawAttributes;
        $test = [];

//        foreach ($rawAttributes as $attribute) {
//            $id = $attribute->id;
//            // 1. If this is the first time seeing this attribute ID, initialize it
//            if (!isset($test[$id])) {
//                $test[$id] = [
//                    'id'     => $id,
//                    'name'   => $attribute->name,
//                ];
//            }
//            // 2. Push the variation into the 'values' array safely
//            $test[$id]['values'][] = [
//                "attr_val_id" => $attribute->attr_val_id,
//                'value'       => $attribute->value,
////                'count'  => count($attribute->attr_val_id),
//
//            ];
//        }
//        return array_values($test);


        foreach ($rawAttributes as $attribute) {
            $id = $attribute->id;

            // 1. Initialize the parent attribute if it hasn't been hit yet
            if (!isset($test[$id])) {
                $test[$id] = [
                    'id'     => $id,
                    'name'   => $attribute->name,
                    'values' => []
                ];
            }

            // 2. Simply push the unique variation along with its count
            $test[$id]['values'][] = [
                "attr_val_id" => $attribute->attr_val_id,
                'value'       => $attribute->value,
                'count'       => (int) $attribute->product_count, // Set from the SQL count
            ];
        }

        return array_values($test);
    }


}
