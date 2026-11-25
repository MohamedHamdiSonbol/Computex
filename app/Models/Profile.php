<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['mobile', 'address', 'governorate_id', 'city_id', 'profileable_id', 'profileable_type'];

    public function profileable()
    {
        return $this->morphTo();
    }

    public function governorate(): BelongsTo{
        return $this->belongsTo(Governorate::class);
    }

    public function city(): BelongsTo{
        return $this->belongsTo(City::class);
    }
}
