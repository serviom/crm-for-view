<?php

namespace App\Policies;

use App\Models\LandPurpose;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandPurposePolicy
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
        return $user->hasPermissionTo('land_purpose.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandPurpose  $landPurpose
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LandPurpose $landPurpose)
    {
        return $user->hasPermissionTo('land_purpose.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('land_purpose.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandPurpose  $landPurpose
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LandPurpose $landPurpose)
    {
        return $user->hasPermissionTo('land_purpose.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandPurpose  $landPurpose
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LandPurpose $landPurpose)
    {
        return $user->hasPermissionTo('land_purpose.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandPurpose  $landPurpose
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LandPurpose $landPurpose)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LandPurpose  $landPurpose
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LandPurpose $landPurpose)
    {
        //
    }
}
