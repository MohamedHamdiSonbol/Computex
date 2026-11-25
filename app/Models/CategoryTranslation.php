<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CategoryTranslation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $table = 'category_translations';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'language_id',
    ];

public function category(): BelongsTo{
    return $this->belongsTo(Category::class);
}
public function language(): BelongsTo{
    return $this->belongsTo(Language::class);
}


    public function scopeSelection($query){
        return $query->select('category_id', 'language_id', 'name', 'slug', 'description');
    }




    protected static function booted()
    {
//        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name, '-', null);
        });
    }
}
