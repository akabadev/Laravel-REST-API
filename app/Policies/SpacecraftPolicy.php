<?php

namespace App\Policies;

use App\Models\Spacecraft;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SpacecraftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Spacecraft  $spacecraft
     * @return mixed
     */
    public function view(User $user, Spacecraft $spacecraft)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Spacecraft  $spacecraft
     * @return mixed
     */
    public function update(User $user, Spacecraft $spacecraft)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Spacecraft  $spacecraft
     * @return mixed
     */
    public function delete(User $user, Spacecraft $spacecraft)
    {
        //can only delete if the user is logged and has the fleet id as spacecraft
        return Auth::check() and $user->fleet_id == $spacecraft->fleet_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Spacecraft  $spacecraft
     * @return mixed
     */
    public function restore(User $user, Spacecraft $spacecraft)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Spacecraft  $spacecraft
     * @return mixed
     */
    public function forceDelete(User $user, Spacecraft $spacecraft)
    {
        //can only delete if the user is logged and has the fleet id as spacecraft
        return Auth::check() and $user->fleet_id == $spacecraft->fleet_id;
    }
}
