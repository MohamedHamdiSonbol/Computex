<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAttributeValue extends Pivot
{
    use HasFactory;

    protected $table = 'product_attribute_values';

    public $fillable = ['product_id', 'attribute_value_id'];

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class);
    }


}
