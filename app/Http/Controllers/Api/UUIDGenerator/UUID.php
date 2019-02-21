<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\UUIDGenerator;

use Webpatser\Uuid\Uuid as UUIDPackage;

use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\UUIDExceptions\GennerateUUID5NameNotDefined;


class UUID
{
    private $version = 5;
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
            $uuid = UUIDPackage::generate($this->version, $this->domainName, UUIDPackage::NS_DNS);
        } catch (\Exception $e) {
            throw new GenerateUUID5Failed();
        }
        if ($uuid == null || $uuid == '') throw new GenerateUUID5Failed();

        return (string)$uuid;
    }
}
