<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GovernorateTranslation extends Model
{
    use HasFactory;

    protected $table = 'governorate_translations';

    protected $fillable = ['governorate_id', 'language_id', 'name'];

    public function governorate(): BelongsTo{
        return $this->belongsTo(Governorate::class);
    }

    public function language(): HasOne{
        return $this->hasOne(Language::class);
    }
}
