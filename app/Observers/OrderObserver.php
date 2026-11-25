<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Product "creating" event.
     */
    public function creating(Order $order)
    {
        // Generate a random unique number
        do {
            $number = 'LT-' . random_int(100000, 999999);
        } while (Order::where('order_number', $number)->exists());

        $order->order_number = $number;
    }

}
