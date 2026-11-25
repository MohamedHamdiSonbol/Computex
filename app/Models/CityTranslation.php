<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CityTranslation extends Model
{
    use HasFactory;

    protected $table = 'city_translations';

    protected $fillable = ['city_id','language_id','name'];

    public function language(): HasOne{
        return $this->hasOne(Language::class);
    }

    public function city(): HasOne{
        return $this->hasOne(City::class);
    }
}
