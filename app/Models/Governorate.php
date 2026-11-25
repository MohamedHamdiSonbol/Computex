<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Governorate extends Model
{
    use HasFactory;

    protected $table = 'governorates';

//    protected $fillable = ['governorate_name'];

    public function cities(): HasMany {
        return $this->hasMany(City::class);
    }

    public function city(): HasOne {
        return $this->hasOne(City::class);
    }

    public function translations(): HasMany {
        return $this->hasMany(GovernorateTranslation::class);
    }

    public function translation(): HasOne {
        return $this->hasOne(GovernorateTranslation::class);
    }


    public function scopeGetAllGovernoratesTranslations($query, $lang){
        $languageId = Language::where('abbr', $lang)->value('id');
        return $query
            ->whereHas('translation')
            ->select('id')
            ->with(['translation' => fn($q) => $q
                ->where('language_id', $languageId)
                ->select('governorate_id', 'language_id', 'name')
        ])->get();
    }


}
