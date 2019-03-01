<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\Api\Log\TimePuncher\Contracts\TimePuncherContract;
use App\Http\Controllers\Api\Log\ClockInDomain\Services\ClockInService;

class ClockInServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $retriever;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(TimePuncherContract::class);
        $this->service = new ClockInService($this->retriever);
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
    }

    /**
     * Clock In test 
     *
     * @return void
     */
    public function test_clock_in_service_get_user_location_and_user_time_sheet_id_with_mockery()
    {
        $currentLocation = "blob";
        $user = "user";

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "log_uuid" => "uuid"
        ];

        $this->retriever
            ->shouldReceive('getUserLocationAndUserTimeSheetId')
            ->with($user, $currentLocation)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->getUserLocationAndUserTimeSheetId($user, $currentLocation);

        $this->assertEquals($expectedResponse, $response);
    }
}
