<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    static $user=[];
    public function __construct()
    {
        //
    }


    public function isAlive(User $u){
        return $u->is_active?true:false;
    }

    public function accessAdmin(User $u){
        return ($u->role==1 and $u->is_active);
    }

    public function accessPusat(User $u){
        return (in_array($u->role,[1,2]) and ($u->is_active?true:false));
    }



}
