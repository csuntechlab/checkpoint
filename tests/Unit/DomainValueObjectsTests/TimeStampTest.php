<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;
use \App\Excetptions\TimeLogExceptions\TimeStamp\GenerateTimeStampFailed;
use \App\DomainValueObjects\UUIDGenerator\UUID;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimeStampTest extends TestCase
{

    public function test_a_timeStamp_is_successfully_created()
    {
        $date = "2019-02-01";
        $time = "06:30:44";
        $UUID = new UUID("domainName");
        $timeStamp = new TimeStamp($UUID, $date, $time);
        $this->assertInstanceOf(TimeStamp::class, $timeStamp);
    }

    public function test_Invalid_timeStamp_throws_exception()
    {
        $this->expectException('App\Exceptions\TimeLogExceptions\TimeStamp\GenerateTimeStampFailed');
        $exception = new TimeStamp();
    }

    public function test_get_Time_Stamp_String()
    {
        $date = "2019-02-01";
        $time = "06:30:44";
        $expectedResponse = $date . " " . $time;
        $UUID = new UUID("domainName");
        $timeStamp = new TimeStamp($UUID, $date, $time);

        $timeStampString = $timeStamp->getTimeStampString();

        $this->assertEquals($expectedResponse, $timeStampString);
    }
}
