<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */

    public $temp_photo;

    protected $fillable = [
        'photo',
        'active',
    ];

    public function translation(): HasOne {
        return $this->hasOne(CategoryTranslation::class);
    }

    public function translations(): HasMany{
        return $this->hasMany(CategoryTranslation::class);
    }

    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }

    public function campaigns(): MorphMany{
        return $this->morphMany(Campaign::class, 'campaignable');
    }






    protected function activeText(): Attribute{
        return Attribute::make(
            get: fn() => $this->active ? 'مفعل' : 'غير مفعل',
        );
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => !empty($attributes['photo'])
                ? asset("assets/admin/images/products/" . $attributes['photo'])
                : asset("assets/admin/default.png"),
        );
    }



    public function scopeWithTranslation($query, $lang) {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('active', 1)
            ->whereHas('translation', fn($q) => $q->where('language_id', $languageId))
            ->select('id', 'photo', 'active')
            ->with(['translation'  => fn($q) => $q->where('language_id', $languageId)->select('category_id', 'name', 'slug')]);
    }


    public function WithLoadCategoryTranslationsRelations(){
       return  $this->load('translations.language:id,abbr');
    }

    public function WithLoadCategoryActiveTranslationRelation($lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $this->load(['translation' => fn($q) => $q->where('language_id', $languageId)->select('category_id', 'name', 'slug', 'description')]);
    }

    protected static function booted(){
//        parent::boot();
        Category::observe(CategoryObserver::class);
    }
}
