<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
    use HasFactory;

    protected $table = 'attribute_value_translations';

    protected $fillable = ['attribute_value_id', 'language_id', 'value'];

    public function language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

}
