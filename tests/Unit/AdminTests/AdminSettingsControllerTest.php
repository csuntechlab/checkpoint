<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Requests
use App\Http\Requests\Admin\AdminSettingCategoriesRequest;
use App\Http\Requests\Admin\AdminSettingPayPeriodRequest;

// Models
use App\Models\PayPeriodType;
//Contracts
use \App\Contracts\AdminSettingsContract;

// Controllers
use \App\Http\Controllers\AdminSettingsController;

class AdminSettingsControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;
    private $userModelRepository;
    private $repository;
    private $user = null;

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
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_mock_admin_settings_getOrganizationSettings_test()
    {
        $expectedResponse = [
            "organizationSetting" => [
                "pay_period_type_id" => "id",
                "time_calculator_type_id" => null,
                "categories" => 1
            ],
            "payPeriodType" => [
                [
                    "id" => "id",
                    "name" => "Weekly"
                ],
                [
                    "id" => "id",
                    "name" => "Monthly"
                ],
                [
                    "id" => "id",
                    "name" => "Yearly"
                ],
                [
                    "id" => "id",
                    "name" => "Custom"
                ]
            ],
            "completed" => true
        ];

        $this->utility
            ->shouldReceive('getOrganizationSettings')
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->getOrganizationSettings();
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_mock_admin_settings_updateCategories_test()
    {
        $input = ['categoriesOptIn' => 1];

        $request = new AdminSettingCategoriesRequest($input);

        $expectedResponse = [
            "pay_period_type_id" => "id",
            "time_calculator_type_id" => null,
            "categories" => 1
        ];

        $this->utility
            ->shouldReceive('updateCategories')
            ->with($this->user->organization_id, $request['categoriesOptIn'])
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->updateCategories($request);
        $this->assertEquals($expectedResponse, $response);
    }

    private function getPayPeriodByName($name)
    {
        return PayPeriodType::where('name', $name)->first();
    }

    public function test_mock_admin_settings_update_payPeriod()
    {
        $startDate = '2019-04-07';
        $endDate = '2019-04-30';

        $payPeriodType = $this->getPayPeriodByName("Monthly");

        // $input = ['startDate' => $startDate, 'endDate' => $endDate];
        $input = ['startDate' => $startDate];

        $request = new AdminSettingPayPeriodRequest($input);

        $expectedResponse = [
            "pay_period_type_id" => $payPeriodType->id,
            "time_calculator_type_id" => null,
            "categories" => 1
        ];

        $this->utility
            ->shouldReceive('updatePayPeriod')
            ->with($this->user->organization_id, $payPeriodType->id)
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->updatePayPeriod($payPeriodType, $request);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_mock_admin_settings_update_payPeriod_custom_fails()
    {
        $startDate = '2019-04-07';
        $payPeriodType = $this->getPayPeriodByName("Custom");
        $input = ['startDate' => $startDate];

        $request = new AdminSettingPayPeriodRequest($input);

        $expectedResponse = [
            "message" => "Custom type requires an End Date",
            "errors" => [
                "endDate" => [
                    "End date is required!"
                ]
            ]
        ];

        $this->utility
            ->shouldReceive('updatePayPeriod')
            ->with($this->user->organization_id, $payPeriodType->id)
            ->andReturn($expectedResponse);

        $response = $this->controller->updatePayPeriod($payPeriodType, $request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_mock_admin_settings_update_payPeriod_custom_passes()
    {
        $startDate = '2019-04-07';
        $endDate = '2019-04-30';
        $payPeriodType = $this->getPayPeriodByName("Custom");
        $input = ['startDate' => $startDate, 'endDate' => $endDate];

        $request = new AdminSettingPayPeriodRequest($input);

        $expectedResponse = [
            "pay_period_type_id" => $payPeriodType->id,
            "time_calculator_type_id" => null,
            "categories" => 1
        ];

        $this->utility
            ->shouldReceive('updatePayPeriod')
            ->with($this->user->organization_id, $payPeriodType->id)
            ->andReturn($expectedResponse);

        $response = $this->controller->updatePayPeriod($payPeriodType, $request);

        $this->assertEquals($expectedResponse, $response);
    }
}
