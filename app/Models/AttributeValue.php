<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';

    protected $fillable = ['attribute_id'];

    public function translation(): HasOne{
        return $this->hasOne(AttributeValueTranslation::class, 'attribute_value_id');
    }

    public function translations(): HasMany{
        return $this->hasMany(AttributeValueTranslation::class, 'attribute_value_id');
    }

    public function attribute(): BelongsTo{
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_attribute_values'
        );
    }

    public function scopeSelect_Attr_Value_Trans_main_active_lang(Builder $query, $lang, $id ){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('attribute_id', $id)->select('id', 'attribute_id')
            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)->select( 'attribute_value_id', 'language_id', 'value')]);
    }

    public function scopeSelectAll_Attr_Value_Trans_main_active_lang(Builder $query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->select('id', 'attribute_id')
            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)->select( 'attribute_value_id', 'language_id', 'value')]);
    }

    public function scopeSelect_Attr_Values_Trans_main_active_lang(Builder $query, $lang, $ids){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->whereIn('attribute_id', $ids)->select('id', 'attribute_id')
            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)->select( 'attribute_value_id', 'language_id', 'value')]);
    }
//->groupBy('attribute_id')
    public function scopeSelect_Attr_Value_Trans_all_active_langs(Builder $query, $id)
    {
        return $query->where('attribute_id', $id)->select('id', 'attribute_id')
            ->with(['translations' => fn($q) => $q->select('attribute_value_id', 'language_id', 'value')]);
    }

}
