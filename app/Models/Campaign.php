<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['starts_at', 'ends_at', 'campaignable_type', 'campaignable_id', 'priority', 'is_active', 'is_stackable'];
    protected $appends = ['campaignable_label'];


    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
    ];
// Adding (New) word for the new products arrived less than month ago
    /**
     * Get the parent target model (Product, Category, or Brand).
     */
    public function campaignable(): MorphTo
    {
        return $this->morphTo();
    }

    public function translation(): HasOne {
        return $this->hasOne(CampaignTranslation::class);
    }

    public function translations(): HasMany{
        return $this->hasMany(CampaignTranslation::class);
    }

    public function scopeCampaigns($query){
        return $query->where('is_active', 1);
    }

    // app/Models/Campaign.php

    public static function getCampaignableTypes()
    {
        return [
            'all'      => __('All Site Products'),
            'brand'    => __('Brand'),
            'category' => __('Category'),
            'product'  => __('Product'),
        ];
    }

    public function discount(): MorphOne{
        return $this->morphOne(Discount::class, 'discountable');
    }

    /**
     * A campaign can have multiple specific discount rules.
     */
//    public function discounts(): HasMany
//    {
//        return $this->hasMany(Discount::class);
//    }

    /**
     * Scope to only include currently running campaigns.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }


    public function scopeWithTranslation($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereHas('translation')
            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)
                ->select('campaign_id', 'name')]);
    }

//    public function scopeWithCampaignableTypeData($query, $lang){
//        $languageId = Language::where('abbr', $lang)->value('id');
//
//        return $query->with(['campaignable' => fn($morphTo) => $morphTo->morphWith([
//                Brand::class => ['translation' => fn($q) => $q->where('language_id', $languageId)],
//                Category::class => ['translation' => fn($q) => $q->where('language_id', $languageId)],
//                Product::class => ['translation' => fn($q) => $q->where('language_id', $languageId)],
//            ])
//        ]);
//    }


    protected function campaignableLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->campaignable_type === null) {
                    return 'All Site';
                }

                // Fallback: If for some reason the relation isn't loaded,
                // find the translation for the current app locale
                $translation = $this->campaignable->translation()
                    ->whereHas('language', fn($q) => $q->where('abbr', app()->getLocale()))
                    ->first();

                return $translation->name;
            },
        );
    }



    protected function isActiveText(): Attribute{
        return Attribute::make(
//            get: fn() => $this->is_active ? 'مفعل' : 'غير مفعل',

            // Use the __() helper so it translates based on app()->getLocale()
            get: fn() => $this->is_active ? __('Active') : __('Inactive'),
        );
    }

    protected function isStackableText(): Attribute{
        return Attribute::make(
            get: fn() => $this->is_stackable ? 'مفعل' : 'غير مفعل',
        );
    }


}
