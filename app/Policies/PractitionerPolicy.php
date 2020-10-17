<?php

namespace App\Policies;

use App\User;
use App\Practitioner;
use Illuminate\Auth\Access\HandlesAuthorization;

class PractitionerPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any practitioners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the practitioner.
     *
     * @param  \App\User  $user
     * @param  \App\Practitioner  $practitioner
     * @return mixed
     */
    public function view(User $user, Practitioner $practitioner)
    {
        //

    }

    /**
     * Determine whether the user can create practitioners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the practitioner.
     *
     * @param  \App\User  $user
     * @param  \App\Practitioner  $practitioner
     * @return mixed
     */
    public function update(User $user, Practitioner $practitioner)
    {
        //


    }

    /**
     * Determine whether the user can delete the practitioner.
     *
     * @param  \App\User  $user
     * @param  \App\Practitioner  $practitioner
     * @return mixed
     */
    public function delete(User $user, Practitioner $practitioner)
    {
        //
    }

    /**
     * Determine whether the user can restore the practitioner.
     *
     * @param  \App\User  $user
     * @param  \App\Practitioner  $practitioner
     * @return mixed
     */
    public function restore(User $user, Practitioner $practitioner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the practitioner.
     *
     * @param  \App\User  $user
     * @param  \App\Practitioner  $practitioner
     * @return mixed
     */
    public function forceDelete(User $user, Practitioner $practitioner)
    {
        //
    }
}
