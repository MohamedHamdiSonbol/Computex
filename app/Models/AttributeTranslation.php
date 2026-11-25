<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeTranslation extends Model
{
    use HasFactory;

    protected $table = 'attribute_translations';
    protected $fillable = [
        'id',
        'attribute_id',
        'language_id',
        'name',
    ];

    public function attribute(): BelongsTo{
        return $this->belongsTo(Attribute::class);
    }

    public function language(): BelongsTo{
        return $this->belongsTo(Language::class);
    }

}
