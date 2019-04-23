<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Carbon\Carbon;

// TB Requests
use App\Http\Requests\ClockInRequest;

//Contracts
use \App\Http\Controllers\ClockInController;
use \App\Contracts\ClockInContract;

class ClockInControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;

    private $classPath = '\App\Http\Controllers\ClockInController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(ClockInContract::class);
        $this->controller = new ClockInController($this->utility);
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    /**
     * A Mockery Test for ClockIn Contoller
     *
     * @return json
     */
    public function test_clock_in_controller_with_mockery()
    {
        $date = "2019-02-01";
        $time = "06:30:44";

        $input = [
            "date" => $date,
            "time" => $time
        ];

        $request = new ClockInRequest($input);

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "log_uuid" => "id",
            "time_sheet_id" => "id",
            "date" => $date,
            "time" => $time
        ];

        $this->utility
            ->shouldReceive('clockIn')
            ->with($request['date'], $request['time'])
            ->once()->andReturn($expectedResponse);

        $response = $this->controller->clockIn($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_login_http_request()
    {
        $date = "2019-02-01";
        $time = "06:30:44";

        $input = [
            "date" => $date,
            "time" => $time
        ];

        $token = $this->get_auth_token($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $token
        ])->json('POST', '/api/clock/in', $input);
        $response = $response->getOriginalContent();

        $this->assertArrayHasKey("message_success", $response);
        $this->assertArrayHasKey("time_sheet_id", $response);
        $this->assertArrayHasKey("log_id", $response);
        $this->assertArrayHasKey("date", $response);
        $this->assertArrayHasKey("time", $response);

        $this->assertNotNull($response["message_success"]);
        $this->assertNotNull($response["time_sheet_id"]);
        $this->assertNotNull($response["log_id"]);
        $this->assertNotNull($response["date"]);
        $this->assertNotNull($response["time"]);
    }
}
