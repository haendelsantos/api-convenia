<?php

namespace App\Policies;

use App\User;
use App\users;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the users.
     *
     * @param  \App\User  $user
     * @param  \App\User  $users
     * @return mixed
     */
    public function update(User $user, User $users)
    {
        return $user->id === $users->id;
    }

    /**
     * Determine whether the user can delete the users.
     *
     * @param  \App\User  $user
     * @param  \App\User  $users
     * @return mixed
     */
    public function delete(User $user, User $users)
    {
        return $user->id === $users->id;
    }
}
