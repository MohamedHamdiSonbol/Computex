<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class City extends Model
{
    use HasFactory;

   protected  $table = 'cities';

   protected $fillable = ['governorate_id'];

    public function governorate(): BelongsTo {
        return $this->belongsTo(Governorate::class);
    }

    public function translations(): HasMany {
        return $this->hasMany(CityTranslation::class);
    }

    public function translation(): HasOne {
        return $this->hasOne(CityTranslation::class);
    }

    public function scopeGetAllCitiesTranslation($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query
            ->whereHas('translation')
            ->select('id')
            ->with(['translation' => fn($q) => $q
                ->where('language_id', $languageId)
                ->select('city_id', 'language_id', 'name')
            ])->get();
    }
}
