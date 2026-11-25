<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category)
    {
        if ($category->temp_photo) {
            save_image($category->temp_photo, 'categories');
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updating(Category $category): void
    {
        if ($category->temp_photo) {
            // 1. Get the OLD filename from the database before it's changed
            $oldPhoto = $category->getOriginal('photo');

            // 2. Delete the old file from the disk
            if ($oldPhoto) {
                delete_image($oldPhoto, 'categories');
            }
            // 3. save the new image
            save_image($category->temp_photo, 'categories');
        }
    }

    public function updated(Category $category): void
    {
        // 1. Did the 'active' column change?
        if ($category->isDirty('active')) {

            // 2. If it was turned OFF (0)
            if ($category->active == 0) {
                // 3. Turn off all products linked to this category
                // This happens automatically as soon as the line above finishes!
                $category->products()->update(['active' => 0]);
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        if ($category->photo) {
            delete_image($category->photo, 'categories');
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
