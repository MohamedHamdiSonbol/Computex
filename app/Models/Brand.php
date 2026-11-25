<?php

namespace App\Models;

use App\Observers\BrandObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Brand extends Model
{
    public $temp_photo;

    protected $fillable = ['logo', 'is_active',
        'active'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function translation(): HasOne {
        return $this->hasOne(BrandTranslation::class);
    }

    public function translations(): HasMany{
        return $this->hasMany(BrandTranslation::class);
    }

    /**
     * This connects the Brand to your Campaign system.
     * It allows you to see all campaigns targeting this brand.
     */
    public function campaigns(): MorphMany{
        return $this->morphMany(Campaign::class, 'campaignable');
    }

    protected function activeText(): Attribute{
        return Attribute::make(
            get: fn() => $this->is_active ? 'مفعل' : 'غير مفعل',
        );
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => !empty($attributes['logo'])
                ? asset("assets/admin/images/brands/" . $attributes['logo'])
                : asset("assets/admin/default.png"),
        );
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }

    public function scopeWithTranslation($query , $lang)
    {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query
            ->join('brand_translations', function ($join) use($languageId) {
            $join->on('brand_translations.brand_id', '=', 'brands.id')
                ->where('brand_translations.language_id', '=', $languageId);
        })
            ->select('brands.id', 'brands.logo', 'brands.is_active', 'brand_translations.name');
    }

    public function loadBrandData(){
        return $this->load(['translations:id,name,language_id,brand_id',
                            'translations.language:id,abbr']);
    }


    protected static function booted(){
//        parent::boot();
        Brand::observe(BrandObserver::class);
    }
}
