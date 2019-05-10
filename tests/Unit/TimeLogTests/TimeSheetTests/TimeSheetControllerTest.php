<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use App\Http\Controllers\TimeSheetController;

// Models
use App\Models\TimeSheet;

// Contracts
use App\Contracts\TimeSheetContract;

class TimeSheetControllerTest extends TestCase
{
  use DatabaseMigrations;
  private $controller;
  private $retriever;

  public function setUp()
  {   
    parent::setUp();
    $this->retriever = Mockery::mock(TimeSheetContract::class);
    $this->controller = new TimeSheetController($this->retriever);

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
  
  public function test_getTimeSheetByDate()
  {
    $request = [
        'date' => Carbon::now()
    ];

    $date = $request['date'];

    $expectedResponse = [];

    $this->retriever
        ->shouldReceive('getTimeSheetByDate')
        ->with($date)
        ->Once()
        ->andReturn($expectedResponse);

    $response = $this->retriever->getTimeSheetByDate($date);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_getTimeSheetByDate_http_call()
  {
      $request = [
          'date' => Carbon::now()->toDateTimeString()
      ];

      $date = Carbon::now();

      $month = $date->month;
      $day = $date->day;
      $year = $date->year;

      $date = $year.'-'.$month.'-'.$year;
      $api_route = '/api/timesheet?='.$date;

      $token = $this->get_auth_token($this->user);

      $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Content-Type' => 'application/x-ww-form-urlencoded',
          'Authorization' => $token
      ])->json('GET', $api_route, $request);

      $response = $response->getOriginalContent();

      $start_date = Carbon::parse($response->start_date);
      $end_date = Carbon::parse($response->end_date);
      $current_date = Carbon::parse($request['date']);

      $this->assertTrue($current_date->between($start_date, $end_date));
  }

}