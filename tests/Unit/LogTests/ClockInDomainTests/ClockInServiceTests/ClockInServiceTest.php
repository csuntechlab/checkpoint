<?php

namespace Tests\Feature;

use Tests\TestCase;
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
        // $this->retriever = Mockery::mock(TimePuncherContract::class);
        // $this->service = new ClockInService($this->retriever);
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertEquals("", "");
        // $input = ["timeStamp" => "2019-02-01 06:30:44", "location" => "blob"];

        // $request = new Request($input);

        // $expectedResponse = [
        //     "message_success" => "Clock in was successfull",
        //     "log_uuid" => "uuid"
        // ];

        // $this->retriever
        //     ->shouldReceive('clockIn')
        //     ->with($request)
        //     ->once()->andReturn($expectedResponse);

        // $response = $this->retriever->clockIn($request);

        // $this->assertEquals($expectedResponse, $response);
    }
}
