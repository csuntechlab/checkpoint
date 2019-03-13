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
use \App\Http\Controllers\Api\TimeLog\ClockInDomain\ClockInController;
use \App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;

class ClockInControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;

    private $classPath = '\App\Http\Controllers\Api\TimeLog\ClockInDomain\ClockInController';

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(ClockInContract::class);
        $this->controller = new ClockInController($this->retriever);
        // $this->seed('OrgnaizationSeeder');
        // $this->seed('UsersTableSeeder');
        // $this->seed('TimeSheetSeeder');
    }

    /**
     * A Mockery Test for ClockIn Contoller
     *
     * @return json
     */
    public function test_clock_in_controller_with_mockery()
    {
        $input = ["timeStamp" => "2019-02-01 06:30:44", "location" => "blob"];

        $expectedResponse = [
            "message_success" => "Clock in was successfull",
            "log_uuid" => "uuid"
        ];

        $this->retriever
            ->shouldReceive('clockIn')
            ->with($input['timeStamp'], $input['location'])
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->clockIn($input['timeStamp'], $input['location']);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * A Mockery Test for get_param in ClockIn Contoller
     *
     * @return array
     */
    public function test_get_param()
    {
        $input = ["timeStamp" => "2019-02-01 06:30:44", "currentLocation" => "blob"];
        $request = new Request($input);

        $function = 'getParam';

        $method = $this->get_private_method($this->classPath, $function);

        $response = $method->invoke($this->controller, $request);

        $this->assertEquals($response, $input);
        $this->assertArrayHasKey('timeStamp', $input);
        $this->assertArrayHasKey('currentLocation', $input);
        $this->assertInternalType('array', $response);
    }
}
