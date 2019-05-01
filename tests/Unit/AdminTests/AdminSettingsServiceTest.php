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

    public function test_currentOrganizationSettings_service()
    {
        $response = $this->service->currentOrganizationSettings($this->user->organization_id);
        $this->assertArrayHasKey('organizationSetting', $response);
        $this->assertArrayHasKey('payPeriodType', $response);
        $this->assertArrayHasKey('completed', $response);
        $organizationSetting = $response['organizationSetting'];
        $payPeriodType = $response['payPeriodType'];
        $completed = $response['completed'];
        $this->assertInstanceOf(OrganizationSetting::class, $organizationSetting);
        $this->assertInternalType('boolean', $completed);
        // dd($response);
    }
}
