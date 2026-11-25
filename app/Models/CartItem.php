<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $fillable = ['customer_id', 'product_id', 'color_id', 'quantity'];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    public function color(): BelongsTo{
        return $this->belongsTo(Color::class);
    }



//    protected function unitPrice(): Attribute {
//        return Attribute::make(
//            get: fn () => $this->product->current_price, // Grab live price from relation
//        );
//    }

//    protected function totalPrice(): Attribute {
//        return Attribute::make(
//            get: fn () => $this->product->final_price * $this->quantity, // Simple math
//        );
//    }

}
