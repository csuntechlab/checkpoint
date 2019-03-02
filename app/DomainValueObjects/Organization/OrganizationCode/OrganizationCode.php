<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\Organization\OrganizationCode;

use App\DomainValueObjects\UUIDGenerator\UUID;

//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Organization Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationIdNotDefined;

class OrganizationCode
{
    public $uuid;
    public $code;

    public function __construct(UUID $uuid = null, string $code = null)
    {
        $this->uuid = $uuid;
        //TODO: do a query to get organization id 
        $this->code = $code;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->code == null || $this->code == '') throw new OrganizationIdNotDefined();
    }
}
