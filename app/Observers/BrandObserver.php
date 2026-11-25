<?php

namespace App\Observers;


use App\Models\Brand;

class BrandObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Brand $brand)
    {
        if ($brand->temp_photo) {
            save_image($brand->temp_photo, 'brands');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updating(Brand $brand): void
    {
        if ($brand->temp_photo) {
            // 1. Get the OLD filename from the database before it's changed
            $oldPhoto = $brand->getOriginal('logo');

            // 2. Delete the old file from the disk
            if ($oldPhoto) {
                delete_image($oldPhoto, 'brands');
            }
            // 3. save the new image
            save_image($brand->temp_photo, 'brands');
        }
    }

    public function updated(Brand $brand): void
    {
        // 1. Did the 'active' column change?
        if ($brand->isDirty('is_active')) {

            // 2. If it was turned OFF (0)
            if ($brand->is_active == 0) {
                // 3. Turn off all products linked to this category
                // This happens automatically as soon as the line above finishes!
                $brand->products()->update(['active' => 0]);
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        if ($brand->logo) {
            delete_image($brand->logo, 'brands');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Brand $brand): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Brand $brand): void
    {
        //
    }
}
