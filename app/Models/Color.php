<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $fillable = ['id', 'name', 'is_active'];
/*
|=========================================================================================
| 🔗 Relationships
|=========================================================================================
*/

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'product_color')->withPivot('quantity');
    }


/*
 |========================================================================================
 | ⚡ Accessors & Mutators
 |========================================================================================
*/
    protected function activeText(): Attribute{
        return Attribute::make(
            get: fn() => $this->is_active ? 'مفعل' : 'غير مفعل',
        );
    }


    /////////////////////////////// newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww//////////////////////////////////
    public function scopeGetAllColors(){
        return $this->select('id', 'name', 'is_active');
    }


    /////////////////////////////// newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww//////////////////////////////////


}
