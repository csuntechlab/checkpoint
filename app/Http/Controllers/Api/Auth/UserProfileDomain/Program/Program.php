<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain\Program;

use App\Http\Controllers\Api\UUIDGenerator\UUID;
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

class Program
{
    private $uuid;
    private $program_name;
    private $program_location = null;
    private $current_time_frame;

    public function __construct(
        UUID $uuid = null,
        ProgramName $program_name = null,
        Location $program_location = null,
        TimeFrame $time_frame = null
    ) {
        $this->uuid = $uuid->toString;
        $this->program_name = $program_name;
        $this->program_location = $program_location;
        $this->current_time_frame = $time_frame;
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->program == null) {
            throw new ProgramNotDefined();
        } else {
            $this->program_location = $this->validate_program_location();
            $this->current_time_frame = $this->validate_program_time_frame();
        }
    }

    public function set_program_location()
    { }

    public function get_program_location()
    { }
}
