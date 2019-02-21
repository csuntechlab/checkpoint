<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Auth\UserProfileDomain\Program\ProgramId;

use App\Http\Controllers\Api\UUIDGenerator\UUID;


//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Program Exceptions
use App\Exceptions\ProgramExceptions\ProgramIdNotDefined;

class ProgramName
{
    public $uuid;
    public $programId;

    public function __construct(UUID $uuid = null, string $programId = null)
    {
        $this->uuid = $uuid;
        //TODO: do a query to get program id 
        $this->programId = $programId;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->programId == null || $this->programId == '') throw new ProgramIdNotDefined();
    }
}
