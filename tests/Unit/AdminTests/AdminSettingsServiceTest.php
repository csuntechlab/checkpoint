<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\AdminSettingsService;
use App\Models\PayPeriodType;
use App\Models\OrganizationSetting;

class AdminSettingsServiceTest extends TestCase
{
    private $service;
    private $classPath = "App\Services\AdminSettingsService";
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->service = new AdminSettingsService();

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_getOrganizationSettings_service()
    {
        $response = $this->service->getOrganizationSettings($this->user->organization_id);
        $this->assertArrayHasKey('organizationSetting', $response);
        $this->assertArrayHasKey('payPeriodType', $response);
        $this->assertArrayHasKey('completed', $response);
        $organizationSetting = $response['organizationSetting'];
        $payPeriodType = $response['payPeriodType'];
        $completed = $response['completed'];
        $this->assertInstanceOf(OrganizationSetting::class, $organizationSetting);
        $this->assertInternalType('boolean', $completed);
        $this->assertCount(4, $payPeriodType);
    }

    private function updateCategories($categoriesOpt)
    {
        return $this->service->updateCategories($this->user->organization_id, $categoriesOpt);
    }

    private function categoriesAssertions($categoriesOpt)
    {
        $response = $this->updateCategories($categoriesOpt);
        $this->assertArrayHasKey('organization_id', $response);
        $this->assertArrayHasKey('pay_period_type_id', $response);
        $this->assertArrayHasKey('time_calculator_type_id', $response);
        $this->assertArrayHasKey('categories', $response);
        $this->assertEquals($categoriesOpt, $response['categories']);
    }


    public function test_updateCategories_optIn()
    {
        $categoriesOptIn = 1;
        $this->categoriesAssertions($categoriesOptIn);
    }

    public function test_updateCategories_optOut()
    {
        $categoriesOptOut = 0;
        $this->categoriesAssertions($categoriesOptOut);
    }

    private function updatePayPeriod($name)
    {
        $payPeriodType = PayPeriodType::where('name', $name)->first();
        return $this->service->updatePayPeriod($this->user->organization_id, $payPeriodType->id);
    }

    private function assertsForUpdatePayPeriod($response)
    {
        $this->assertArrayHasKey('organization_id', $response);
        $this->assertArrayHasKey('pay_period_type_id', $response);
        $this->assertArrayHasKey('time_calculator_type_id', $response);
        $this->assertArrayHasKey('categories', $response);
        $this->assertNotNull($response['pay_period_type_id']);
    }

    public function test_updatePayPeriod_Weekly()
    {
        $response = $this->updatePayPeriod('Weekly');
        $this->assertsForUpdatePayPeriod($response);
    }

    public function test_updatePayPeriod_Monthly()
    {
        $response = $this->updatePayPeriod('Monthly');
        $this->assertsForUpdatePayPeriod($response);
    }

    public function test_updatePayPeriod_Yearly()
    {
        $response = $this->updatePayPeriod('Yearly');
        $this->assertsForUpdatePayPeriod($response);
    }

    public function test_updatePayPeriod_Custom()
    {
        $response = $this->updatePayPeriod('Custom');
        $this->assertsForUpdatePayPeriod($response);
    }
}
