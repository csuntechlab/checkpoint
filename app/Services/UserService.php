<?php
namespace App\Services;

// Models
use App\User;

// Contracts
use App\Contracts\UserContract;


class UserService implements UserContract
{
    // logs that do not have a clock out
    // logs that happened today

    // locations[] by org
    // locations[] by proj
    // radius:
    // mentors ? 
    // currentTimeSheetId
    public function profile(int $userId)
    {
        $profile = User::with(['userRole.role', 'userProject.project', 'userLocation', 'userProject.location'])->where('id', $userId)->get();
        // $profile = User::with('userLocation')->where('id', $userId)->get();
        return $profile;
    }
}
