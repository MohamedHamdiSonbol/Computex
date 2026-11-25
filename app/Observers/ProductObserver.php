<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product)
    {
        if ($product->temp_photo) {
            save_image($product->temp_photo,'products');
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updating(Product $product): void
    {
        if ($product->temp_photo) {
            // 1. Get the OLD filename from the database before it's changed
            $oldPhoto = $product->getOriginal('photo');

            // 2. Delete the old file from the disk
            if ($oldPhoto) {
                delete_image($oldPhoto, 'products');
            }
            // 3. save the new image
            save_image($product->temp_photo, 'products');
        }
    }


    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($product->photo) {
            delete_image($product->photo, 'products');
        }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
