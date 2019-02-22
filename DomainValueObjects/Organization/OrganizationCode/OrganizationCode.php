<?php
declare (strict_types = 1);
namespace DomainValueObjects\Organization\OrganizationCode;

use DomainValueObjects\UUIDGenerator\UUID;

//UUID
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;

//Organization Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationIdNotDefined;

class OrganizationCode
{
    public $uuid;
    public $programCode;

    public function __construct(UUID $uuid = null, string $programCode = null)
    {
        $this->uuid = $uuid->toString;
        //TODO: do a query to get program id 
        $this->programCode = $programCode;
        $this->validate();
    }

    private function validate()
    {
        if ($this->uuid == null || $this->uuid == '') throw new GenerateUUID5Failed();
        if ($this->programCode == null || $this->programCode == '') throw new OrganizationIdNotDefined();
    }
}
