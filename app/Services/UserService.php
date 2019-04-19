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
            'userProject.location',
            'userProject.users.role'
        ])->where('id', $userId)->first();

        return $this->generateEmployeeProfile($profile);
    }

    private function generateEmployeeProfile($profile)
    {


        $projects = $profile->userProject;
        $locations = $profile->userLocation;

        $userProjects = collect();

        foreach ($projects as $project) {
            $locations = $locations->concat($project->location);
            $users = collect();
            foreach ($project->users as $member) {
                if ($member->isRole('Mentor')) {
                    $users->push($member);
                }
            }
            unset($project->users);
            $project->users = $users;
            $userProjects->push($project);
        }

        unset($profile->userLocation);
        unset($profile->userProject);
        $profile->userLocation = $locations;
        $profile->userProject = $projects;
        return $profile;
    }
}
