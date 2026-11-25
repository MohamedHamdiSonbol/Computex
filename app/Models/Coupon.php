<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Coupon extends Model
{
    use HasFactory;

protected $table = 'coupons';

protected $fillable = ['starts_at', 'ends_at', 'code', 'is_active'];


    public function discount(): MorphOne{
        return $this->morphOne(Discount::class, 'discountable');
    }


    public function scopeActive($query){
        return $query->where('is_active', 1);
    }

    public function scopeWithDiscount($query){
        return $query->with(['discount' => fn($q) => $q->select(  'discountable_id',  'type', 'value')]);
    }



    protected function isActiveText(): Attribute{
        return Attribute::make(
            get: fn() => $this->is_active ? __('Active') : __('Inactive'),
        );
    }
}
