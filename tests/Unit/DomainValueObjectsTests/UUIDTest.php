<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\DomainValueObjects\UUIDGenerator\UUID;

class UUIDTest extends TestCase
{
    public function test_UUID_creaion_successful()
    {
        $uuid = new UUID('domain_name');
        $this->assertInstanceOf(UUID::class, $uuid);
    }

    public function test_UUID_creaion_fails_throws_GennerateUUID5NameNotDefined_exception()
    {
        $this->expectException('App\Exceptions\UUIDExceptions\GennerateUUID5NameNotDefined');
        $uuid = new UUID('');
    }

    public function test_UUID_creaion_fails_throws_GennerateUUID5NameNotDefined_exception_null()
    {
        $this->expectException('App\Exceptions\UUIDExceptions\GennerateUUID5NameNotDefined');
        $uuid = new UUID();
    }

    public function test_UUID_to_string()
    {
        $uuid = new UUID('domain_name');
        $toString = $uuid->toString;

        $this->assertInternalType('string', $toString);
        $this->assertInstanceOf(UUID::class, $uuid);
    }
}
