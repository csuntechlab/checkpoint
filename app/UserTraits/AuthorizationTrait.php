<?php

namespace App\UserTraits;

// Models
use App\User;
use App\Models\TimeLog;

// Exception
use Illuminate\Auth\Access\AuthorizationException;
use App\Exceptions\AuthExceptions\UnauthorizedUser;

trait AuthorizationTrait
{
    public function isRole($role)
    {
        return $this->role->contains('name', $role);
    }

    public function isAdmin()
    {
        if (!$this->isRole('Admin')) throw new UnauthorizedUser('Admin');
        return true;
    }

    public function isStudent()
    {
        if (!$this->isRole('Student')) throw new UnauthorizedUser('Student');
        return true;
    }

    public function isMentor()
    {
        if (!$this->isRole('Mentor')) throw new UnauthorizedUser('Mentor');
        return true;
    }

    // public function update(User $user, TimeLog $timeLog)
    public function authorizeTimeLog(TimeLog $timeLog)
    {
        if (
            $this->id !== $timeLog->user_id
            && $this->organization_id !== $timeLog->organization_id
        ) throw new AuthorizationException();
        return true;
    }
}
