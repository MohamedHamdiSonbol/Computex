<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-languages');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Language $language): bool
    {
        return $admin->can('view-languages');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-languages');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Language $language): bool
    {
        return $admin->can('edit-languages');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Language $language): bool
    {
        return $admin->can('delete-languages');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Language $language): bool
    {
        return $admin->can('toggleActive-languages');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Language $language): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Language $language): bool
    {
        //
    }
}
