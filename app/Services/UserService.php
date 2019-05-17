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
        $profile = User::with([
            'role', 'userLocation',
            'userProgram.location',
            'userProgram.users.role'
        ])->where('id', $userId)->first();

        return $this->generateProfile($profile);
    }

    private function generateProfile($profile)
    {
        $programs = $profile->userProgram;
        $locations = $profile->userLocation;

        $userPrograms = collect();

        foreach ($programs as $program) {
            $locations = $locations->concat($program->location);
            $users = collect();
            foreach ($program->users as $member) {
                if ($member->isRole('Mentor')) {
                    $users->push($member);
                }
            }
            unset($program->users);
            $program->users = $users;
            $userPrograms->push($program);
        }

        unset($profile->userLocation);
        unset($profile->userProgram);
        $profile->userLocation = $locations;
        $profile->userProgram = $programs;
        return $profile;
    }
}
