<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\DomainValueObjects\UUIDGenerator\UUID;

class UUIDTest extends TestCase
{
    public function test_UUID_creaion_successful()
    {
        $uuid = UUID::generate();
        $this->assertNotNull($uuid);
        $this->assertInternalType('string', $uuid);
    }
}
