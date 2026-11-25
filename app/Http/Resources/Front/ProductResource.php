<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
//            'id'              => $this->id,
//            'name'            => $this->product_name, // Mapping from the join
//            'slug'            => $this->slug,
//            'image_url'       => $this->photo? asset('assets/admin/images/products/' . $this->photo) : asset("assets/admin/default.png"),

            'product_id'        => $this->product_id ?? $this->translation->product_id ??   '',
            'category_id'       => $this->category_id ??  '',
            'brand_id'          => $this->brand_id ??  '',
            'name'              => $this->product_name ?? $this->translation->name ?? $this->name ?? '',
            'slug'              => $this->slug ?? $this->translation->slug ?? '',
            'description'       => $this->description ?? $this->translation->description ?? '',
            'image_url'         => $this->photo
                                 ? asset('assets/admin/images/products/' . $this->photo)
                                 : ($this->product && $this->product->photo
                                    ? asset('assets/admin/images/products/' . $this->product->photo)
                                    : asset('assets/admin/default.png')),


            'attributes_values' => method_exists($this->resource, 'relationLoaded')
                ? $this->whenLoaded('attributeValues', function () {
                    return $this->attributeValues->mapWithKeys(fn($item) => [
                        $item->translation->attribute_value_id => $item->translation->value
                    ]);
                })
                : $this->attribute_values->mapWithKeys(fn($item) => [
                    $item->attribute->translation->name => $item->translation->value
//                    $item->translation->attribute_value_id => $item->translation->value
                ]),


            'colors'            =>  method_exists($this->resource, 'relationLoaded')
                            ?  $this->whenLoaded('colors', function () {
                            return $this->colors->map(function ($color) {
                                return ['id' => $color->pivot->color_id,
                                        'name' => $color->name,
                                        'quantity' => $color->pivot->quantity];
                            });
                        }) :
                            $this->colors->map(function ($color) {
                                   $item = [
                                        'id'   => $color->id,
                                        'name' => $color->name,
                                        'quantity' => $color->pivot->quantity,
                                    ];
                                   return $item;
                            }),

            'price'             => number_format($this->price, 2),
            'currency'          => 'EGP',
            'quantity'          => $this->quantity,
            'is_out_of_stock'   => $this->quantity <= 0,

            // These only exist if you joined them in the Repo
            'category'          => $this->category_name ?? '',
            'category_slug'          => $this->category_slug ?? '',
            'brand'             => $this->brand_name ?? ' ',
            'new'               => $this->new_arrival_label?? '',

            'discount_percentage'  =>$this->discount_details? ($this->discount_details['label'] ?? '') : null,
            'discount_amount'   => $this->discount_details? (number_format($this->discount_details['amount'], 2) ?? '') : null,
            'final_price'       => number_format($this->final_price ?? $this->price, 2),
        ];
    }
}
