<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\UUIDGenerator;

use Webpatser\Uuid\Uuid as UUIDPackage;
//Exceptions


class UUID
{
    public static function generate()
    {
        $uuid = UUIDPackage::generate();

        return (string)$uuid;
    }
}
