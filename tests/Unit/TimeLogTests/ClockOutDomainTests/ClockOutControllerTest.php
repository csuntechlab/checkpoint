<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Illuminate\Http\Request;

// TB models
use \App\User;

//Contracts
use \App\Http\Controllers\Api\TimeLog\ClockOutDomain\ClockOutController;
use \App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Requests\ClockOutRequest;

class ClockOutControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;

    private $classPath = '\App\Http\Controllers\Api\TimeLog\ClockOutDomain\ClockOutController';

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(ClockOutContract::class);
        $this->controller = new ClockOutController($this->retriever);
    }

    public function test_clock_out_controller_with_mockery()
    {
        $date = "2019-02-01";
        $time = "06:30:44";
        $logId = "id";

        $input = [
            "date" => $date,
            "time" => $time,
            "logId" => $logId
        ];

        $request = new ClockOutRequest($input);

        $expectedResponse =  [
            "message_success" => "Clock out was successfull",
            "time_sheet_id" => "id",
            "log_id" => "id",
            "date" => $date,
            "time" => $time,
        ];

        $this->retriever
            ->shouldReceive('clockIn')
            ->with($request['date'], $request['time'], $request['id'])
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->clockIn($request['date'], $request['time'], $request['id']);

        $this->assertEquals($expectedResponse, $response);
    }
}
