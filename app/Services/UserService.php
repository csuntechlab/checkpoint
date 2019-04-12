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
    // currentTimeSheetId

    // change Location relationship to polymorphic
    // mentors ? 
    public function profile(int $userId)
    {
        $profile = User::with(['userRole.role', 'userProject.project', 'userProject.mentorsProject.mentorProfile.userRole.role' => function ($query) {
            $query->where('name', 'Mentor');
        }, 'userLocation', 'userProject.location'])->where('id', $userId)->get();
        return $profile;
    }
}
