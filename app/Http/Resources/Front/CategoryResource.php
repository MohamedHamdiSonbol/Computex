<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id'     => $this->translation->category_id ?? $this->category_id ??  '',
            'name'            => $this->translation->name ?? $this->name ??  '',
            'slug'            => $this->translation->slug ?? $this->slug ??  '',
            'description'     => $this->translation->description ?? $this->description ??  '',
            'image_url'       => $this->photo
                                 ? asset('assets/admin/images/categories/' . $this->photo)
                                 : ($this->category && $this->category->photo
                                    ? asset('assets/admin/images/categories/' . $this->category->photo)
                                    : asset('assets/admin/images/categories/default.webp')),


            // Optional: You can add a full URL for SEO/Linking
//            'url'         => route('categories.show', $this->translation->slug ?? 'none'),
        ];
    }
}
