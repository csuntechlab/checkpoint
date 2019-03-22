<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Carbon\Carbon;

// TB models
use App\Http\Requests\ClockInRequest;

//Contracts 
use \App\Http\Controllers\Api\TimeLog\ClockInDomain\ClockInController;
use \App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;

class ClockInControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;
    private $loginService;

    private $classPath = '\App\Http\Controllers\Api\TimeLog\ClockInDomain\ClockInController';

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(ClockInContract::class);
        $this->controller = new ClockInController($this->retriever);
        $this->seed('PassportSeeder');
        $this->seed('OrgnaizationSeeder');
        $this->seed('ProgramSeeder');
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
            "log_uuid" => "uuid",
            "time_sheet_id" => "uuid",
            "date" => $date,
            "time" => $time
        ];

        $this->retriever
            ->shouldReceive('clockIn')
            ->with($request['date'], $request['time'])
            ->once()->andReturn($expectedResponse);

        $response = $this->controller->clockIn($request);

        $this->assertEquals($expectedResponse, $response);
    }



    public function test_clockIn_controller_http_call()
    {
        $input = [
            "date" => "2019-02-01",
            "time" => "06:30:44"
        ];

        dd($this->getAuthToken($this->user));

        $this->assertAuthenticated($guard = null);
        $this->assertAuthenticatedAs($this->user, $guard = null);

        $response = $this->json('POST', "api/clock/in", $input);
        // dd($response);
    }
}
