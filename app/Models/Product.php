<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory;

    public $temp_photo;

    protected $table = 'products';

    protected $fillable = ['id', 'price', 'quantity', 'photo', 'active', 'category_id', 'brand_id'];

    protected $appends = ['new_arrival_label']; // Tells Laravel to include these when converting to JSON
/*
|=========================================================================================
| 🔗 Relationships
|=========================================================================================
*/
    public function translations(): HasMany{
        return $this->hasMany(ProductTranslation::class);
    }

    public function translation():HasOne
    {
        return $this->hasOne(ProductTranslation::class);
    }

    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function colors(): BelongsToMany{
        return $this->belongsToMany(Color::class, 'product_color')->withPivot('quantity');
    }

    public function attributeValues(): BelongsToMany{
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attribute_values'
        );
    }

    public function campaigns(): MorphMany{
        return $this->morphMany(Campaign::class, 'campaignable');
    }


/*
 |========================================================================================
 | ⚡ Accessors & Mutators
 |========================================================================================
*/
    protected function discountLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return !empty($this->campaign_name) ? 'OFFER' : null;
            }
        );
    }

    protected function newArrivalLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->created_at->diffInDays(now()) < 80){
                    return 'New';
                }
                return null;
            }
        );
    }

    protected function activeText(): Attribute{
        return Attribute::make(
            get: fn() => $this->active ? 'مفعل' : 'غير مفعل',
        );
    }

//    protected function Photo(): Attribute
//    {
//        return Attribute::make(
//            get: fn($value) => $value ? asset("assets/admin/images/products/" . $value) : asset("assets/admin/default.png"),
//        );
//    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => !empty($attributes['photo'])
                ? asset("assets/admin/images/products/" . $attributes['photo'])
                : asset("assets/admin/default.png"),
        );
    }

    /////////////////////////////// newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww//////////////////////////////////
    public function scopeWithTranslation($query, $lang)
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
    public function scopeWithCategoryName($query)
    {
        return  $query->join('category_translations', function ($join) {
            $join->on('category_translations.category_id', '=', 'products.category_id')
                ->on('category_translations.language_id', '=', 'product_translations.language_id');
        })
            ->addSelect( 'category_translations.name as category_name');
    }

    // Get Brand With Names
    public function scopeWithBrandName($query)
    {
        return $query->join('brand_translations', function ($join) {
            $join->on('brand_translations.brand_id', '=', 'products.brand_id')
                ->on('brand_translations.language_id', '=', 'product_translations.language_id');
        })
            ->addSelect( 'brand_translations.name as brand_name');
    }


    public function loadProductAllWithData($lang){
        $languageId = Language::where('abbr', $lang)->value('id');
     return $this->load(['translations:id,name,slug,description,language_id,product_id',
                          'colors:id',
                          'attributeValues:id,attribute_id',
                          'attributeValues.translation' => fn($q) => $q->where('language_id', $languageId)->select('attribute_value_id', 'value')]);
    }
    /////////////////////////////// newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww//////////////////////////////////

    protected static function booted(){

        Product::observe(ProductObserver::class);
    }

}
