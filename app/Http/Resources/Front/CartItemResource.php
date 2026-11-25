<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'product_id'      => $this->product_id ?? '',
            'product_name'    => $this->product_name ??  '',
            'image_url'       => $this->photo ? asset('assets/admin/images/products/' . $this->photo) :
                                                asset('assets/admin/default.png'),
            'color_id'        => $this->color_id ??  '',
            'color_name'      => $this->color_name ??  '',
            'quantity'        => $this->quantity_in_cart ?? '',
            'final_price'     => $this->final_price ??  '',
            'total_price'     => $this->total_price ?? '',
        ];
    }
}
