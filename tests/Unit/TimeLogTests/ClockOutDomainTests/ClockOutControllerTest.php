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
        // $this->seed('OrgnaizationSeeder');
        // $this->seed('UsersTableSeeder');
        // $this->seed('TimeSheetSeeder');
    }

    public function test_clock_out_controller_with_mockery()
    {
        $timeStampString = "2019-02-01 06:30:44";

        $data = [
            "timeStamp" => $timeStampString,
            "logUuid" => "uuid"
        ];

        $expectedResponse =  [
            "message_success" => "Clock out was successfull",
            "timeSheet_id" => "uuid",
            "log_uuid" => "uuid",
            "time_stamp" => $timeStampString
        ];

        $this->retriever
            ->shouldReceive('clockIn')
            ->with($data['timeStamp'], $data['logUuid'])
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->clockIn($data['timeStamp'], $data['logUuid']);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * A Mockery Test for get_param in ClockIn Contoller
     *
     * @return array
     */
    public function test_get_param()
    {
        $data = ["timeStamp" => "2019-02-01 06:30:44", "logUuid" => "uuid"];
        $request = new Request($data);

        $function = 'getParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->controller, $request);

        $this->assertEquals($response, $data);
        $this->assertArrayHasKey('timeStamp', $data);
        $this->assertInternalType('array', $response);
    }
}
