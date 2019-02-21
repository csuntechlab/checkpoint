<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain\Program\ProgramName;

use App\Http\Controllers\Api\UUIDGenerator\UUID;

class ProgramName
{
    public $uuid;
    public $program_name;

    public function __construct(UUID $uuid = null, string $name = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    private function validate()
    { }
}
