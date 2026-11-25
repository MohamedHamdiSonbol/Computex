<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductTranslation extends Model
{

    protected $fillable = ['name', 'slug', 'description', 'language_id', 'product_id'];

    public function language(): BelongsTo{
        return $this->belongsTo(Language::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name, '-', null);
        });
    }

}


