<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\UUIDGenerator;

use Webpatser\Uuid\Uuid as UUIDPackage;
//Exceptions
use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\UUIDExceptions\GennerateUUID5NameNotDefined;


class UUID
{
    private $domainName = null;
    public $toString = null;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
        $this->validation();
        $this->toString = $this->generateUUID5();
    }

    private function validation()
    {
        if ($this->domainName == null || $this->domainName == '') throw new GennerateUUID5NameNotDefined();
    }


    private function generateUUID5(): string
    {
        $uuid = null;

        try {
            $uuid = UUIDPackage::generate();
        } catch (\Exception $e) {
            throw new GenerateUUID5Failed();
        }
        if ($uuid == null || $uuid == '') throw new GenerateUUID5Failed();

        return (string)$uuid;
    }
}
