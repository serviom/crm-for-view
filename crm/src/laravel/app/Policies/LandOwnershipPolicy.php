<?php

namespace App\Policies;

use App\Models\LandOwnership;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandOwnershipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('land_ownership.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandOwnership  $landOwnership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LandOwnership $landOwnership)
    {
        return $user->hasPermissionTo('land_ownership.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('land_ownership.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandOwnership  $landOwnership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LandOwnership $landOwnership)
    {
        return $user->hasPermissionTo('land_ownership.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandOwnership  $landOwnership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LandOwnership $landOwnership)
    {
        return $user->hasPermissionTo('land_ownership.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandOwnership  $landOwnership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LandOwnership $landOwnership)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandOwnership  $landOwnership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LandOwnership $landOwnership)
    {
        //
    }
}
