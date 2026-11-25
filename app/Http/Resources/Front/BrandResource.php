<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
//            'category_id'     => $this->category_id?? null,
            'brand_id'     => $this->translation->brand_id ?? $this->brand_id ??  '',
            'name'            => $this->translation->name ?? $this->name ??  '',
            'slug'            => $this->translation->slug ?? $this->slug ??  '',
//            'description'     => $this->translation->description ?? $this->description ??  '',
            'image_url'       => $this->logo
                                 ? asset('assets/admin/images/brands/' . $this->logo)
                                 : ($this->brand && $this->brand->logo
                                    ? asset('assets/admin/images/brands/' . $this->brand->logo)
                                    : asset('assets/admin/default.png')),


            // Optional: You can add a full URL for SEO/Linking
//            'url'         => route('categories.show', $this->translation->slug ?? 'none'),
        ];
    }
}
