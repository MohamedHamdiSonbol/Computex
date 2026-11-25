<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute as EloquentAttribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';
    protected $fillable = ['active'];

    public function translation(): hasOne{
        return $this->hasOne(AttributeTranslation::class);
    }

    public function translations(): HasMany{
        return $this->hasMany(AttributeTranslation::class);
    }

    public function values(): HasMany{
        return $this->hasMany(AttributeValue::class);
    }

    public function scopeSelectOneAttr_transWithActiveLang(Builder $query, $lang)
    {
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query->where('active', true)
            ->whereHas('translation', fn($q) => $q->where('language_id', $languageId))
            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)->select('id', 'attribute_id', 'language_id', 'name')]);
    }

//    public function scopeSelect_AllAttr_With_Trans_Main_Lang($query, $lang){
//        $languageId = Language::where('abbr', $lang)->value('id');
//        return $query->where('active', 1)
//            ->with(['translation' => fn($q) => $q->where('language_id', $languageId)]);
//    }


    protected function activeText(): EloquentAttribute{
        return EloquentAttribute::make(
            get: fn() => $this->active ? 'مفعل' : 'غير مفعل',
        );
    }
}
