<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain;

//Exceptions
// List
//User Profile

use App\Exceptions\UserProfileExceptions\UserIdNotDefined;
use App\Exceptions\UserProfileExceptions\UserNameNotDefined;

//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramNotDefined;
use App\Exceptions\ProgramExceptions\ProgramLocationNotDefined;


class UserProfile
{
    private $user_id = null; // UUID
    private $program = null; // Program
    private $name = null; // Name
    private $program_location = null; // Location
    private $current_time_frame = null; // Time Frame

    private $student_location = null; // Location

    public function __construct(string $user_id = null, Program $program = null)
    {
        $this->user_id = $user_id;
        $this->program = $program;
        $this->validate();
    }

    private function validate()
    {
        if ($this->user_id == null || $this->user_id == '') throw new UserIdNotDefined();
        if ($this->program == null) {
            throw new ProgramNotDefined();
        } else {
            $this->program_location = $this->validate_program_location();
            $this->current_time_frame = $this->validate_program_time_frame();
        }
    }

    private function validate_program_location()
    {
        $program_location = $this->program->get_program_location();
        if ($program_location == null) throw new ProgramLocationNotDefined();
        return $program_location;
    }

    private function validate_program_time_frame()
    {
        $current_time_frame = $this->program->get_current_time_frame();
        if ($current_time_frame == null) throw new ProgramTimeFrameNotDefined();
        return $current_time_frame;
    }

    public function get_profile_location()
    { }
}
