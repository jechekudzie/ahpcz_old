<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */


    public function admin(User $user)
    {
        return $user->role_id == 1;

    }


    public function updatePractitioner(User $user)
    {
        return $user->role_id == 3 || $user->role_id == 4 ||$user->role_id == 1;

    }


    public function updatePractitionerShortFalls(User $user)
    {

        if ($user->role_id == 4 || $user->role_id == 6 ||$user->role_id == 1) {
            return true;
        }
    }


    public function updatePractitionerPayment(User $user)
    {
        if ($user->role_id == 5 ||$user->role_id == 1) {
            return true;
        }
    }


    public function updatePractitionerApproval(User $user)
    {
        if (in_array($user->role_id, [1,4, 5, 6, 7], true)) {
            return true;
        }
    }


    //Approval Policies
    public function officerApproval(User $user)
    {
        return $user->role_id === 4 ||$user->role_id == 1;
    }

    public function accountantApproval(User $user)
    {

        if ($user->role_id == 5 ||$user->role_id == 1) {
            return true;
        }
    }


    public function MemberApproval(User $user)
    {

        if ($user->role_id == 6 ||$user->role_id == 1) {
            return true;
        }
    }


    public function registrarApproval(User $user)
    {

        if ($user->role_id == 7 ||$user->role_id == 1) {
            return true;
        }
    }

}
