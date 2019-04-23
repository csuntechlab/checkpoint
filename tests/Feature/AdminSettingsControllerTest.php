<?php

namespace Tests\Feature;

use Tests\TestCase;

// TB Requests
use App\Http\Requests\Admin\AdminSettingsRequest;

//Contracts
use \App\Http\Controllers\AdminSettingsController;
use \App\Contracts\AdminSettingsContract;


class AdminSettingsControllerTest extends TestCase
{
    private $controller;
    private $utility;
    private $repository;

    private $classPath = '\App\Http\Controllers\AdminSettingsController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(AdminSettingsContract::class);
        $this->controller = new AdminSettingsController($this->utility);
        $this->seed('PassportSeeder');
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
}
