<?php 
declare (strict_types = 1);
namespace App\Http\Controllers\Api\UUIDGenerator;

use Webpatser\Uuid\Uuid;

use App\Exceptions\UUIDExceptions\GenerateUUID5Failed;
use App\Exceptions\UUIDExceptions\GennerateUUID5NameNotDefined;


class UUIDGenerator
{
    private static $version = 5;

    public static function generate_uuid_5(string $name = null): string
    {
        $uuid = null;

        if ($name == null) throw new GennerateUUID5NameNotDefined();

        try {
            $uuid = Uuid::generate(self::$version, $name, Uuid::NS_DNS);
        } catch (\Exception $e) {
            throw new GenerateUUID5Failed();
        }

        if ($uuid == null) throw new GenerateUUID5Failed();

        return (string)$uuid;
    }
}
