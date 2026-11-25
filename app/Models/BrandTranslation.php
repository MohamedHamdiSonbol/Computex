<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BrandTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'language_id', 'brand_id'];

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
    public function language(): BelongsTo{
        return $this->belongsTo(Language::class);
    }


    protected static function booted()
    {
//        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name, '-', null);
        });
    }
}
