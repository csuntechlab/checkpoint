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
        // $profile = User::with([
        //     'userRole.role', 'userProject.project',
        //     'userLocation', 'userProject.location',
        //     'userProject.mentorsProject.mentorProfile.userRole.role' => function ($query) {
        //         $query->where('name', 'Mentor');
        //     }
        // ])->where('id', $userId)->first();

        $profile = User::with([
            'userRole.role', 'userProject.project',
            'userLocation', 'userProject.location',
            'userProject.mentorsProject.mentorProfile.userRole.role' => function ($query) {
                $query->where('name', 'Mentor');
            }
        ])->where('id', $userId)->first();
        // dd($profile);
        // return  $profile;
        // return  $profile->userProject;

        foreach ($profile->userProject as $project) {
            // dd($project);
            foreach ($project->mentorsProject as $member) {
                return $member->mentorProfile->userRole;
            }
        }
        // return $profile->user_project;
        return $profile->userProject;
    }
}
