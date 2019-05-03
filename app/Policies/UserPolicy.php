<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Exceptions\AuthExceptions\UnauthorizedUser;

class UserPolicy
{
    use HandlesAuthorization;

    // public function isRole(User $user, $role)
    public function isAdmin(User $user)
    {
        if (!$user->isRole('Admin')) throw new UnauthorizedUser('Admin');
        return true;
    }

    public function isStudent(User $user)
    {
        if (!$user->isRole('Student')) throw new UnauthorizedUser('Student');
        return true;
    }

    public function isMentor(User $user)
    {
        if (!$user->isRole('Mentor')) throw new UnauthorizedUser('Mentor');
        return true;
    }
}
