<?php

namespace Tests\Feature;

use Tests\TestCase;

// TB Requests
use App\Http\Requests\Admin\AdminSettingsRequest;

//Contracts
use \App\Http\Controllers\AdminSettingsController;
use \App\Contracts\AdminSettingsContract;
use App\User;

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
    }

    public function test_mock_admin_settings_controller_test()
    {
        // User::create([]);
    }
}
