<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable=['customer_id', 'coupon_id', 'order_number', 'customer_name', 'phone', 'address', 'shipping', 'fees', 'total_price', 'status'];

    public function items(){
            return $this->hasMany(OrderItem::class);
    }

//    public function scopeSelecting(Builder $query,$lang){
//        $languageId = Language::where('abbr', $lang)->value('id');
//        return $query->whereHas('translation', fn($q) => $q->where('language_id', $languageId))
//            ->select('id', 'order_number', 'total_price', 'status')
//            ->with('translation', fn($q) => $q->where('language_id', $languageId)
//                ->select( 'order_id', 'language_id', 'name'));
//    }

    public function scopeSelecting($query){
        return $query->select('id', 'order_number', 'total_price', 'customer_name', 'status');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            // Only generate if it wasn't manually set (allows for custom IDs if needed)
            if (empty($order->order_number)) {
                $order->order_number = self::generateUniqueNumber();
            }
        });
    }

// We keep this as a separate method so it's easy to test
    protected static function generateUniqueNumber(): string
    {
        do {
            $number = 'LT-' . strtoupper(Str::random(8));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}
