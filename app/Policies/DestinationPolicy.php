<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DestinationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        if (Auth::user()->role == 'admin') {
            return $user->isAdmin();
        } elseif (Auth::user()->role == 'employee') {
            return $user->isEmployee();
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Destination $destination
     * @return mixed
     */
    public function view(User $user, Destination $destination)
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
     * @param Destination $destination
     * @return array
     */
    public function update(User $user, Destination $destination): array
    {
        return compact([$user->isAdmin(),$destination]) ;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Destination $destination
     * @return mixed
     */
    public function delete(User $user, Destination $destination)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Destination $destination
     * @return mixed
     */
    public function restore(User $user, Destination $destination)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Destination $destination
     * @return mixed
     */
    public function forceDelete(User $user, Destination $destination)
    {
        //
    }
}
