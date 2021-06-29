<?php

namespace App\Policies;

use App\Models\BusinessCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param BusinessCategory $businessCategory
     * @return mixed
     */
    public function view(User $user, BusinessCategory $businessCategory)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param BusinessCategory $businessCategory
     * @return mixed
     */
    public function update(User $user, BusinessCategory $businessCategory)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param BusinessCategory $businessCategory
     * @return mixed
     */
    public function delete(User $user, BusinessCategory $businessCategory)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param BusinessCategory $businessCategory
     * @return mixed
     */
    public function restore(User $user, BusinessCategory $businessCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param BusinessCategory $businessCategory
     * @return mixed
     */
    public function forceDelete(User $user, BusinessCategory $businessCategory)
    {
        //
    }
}
