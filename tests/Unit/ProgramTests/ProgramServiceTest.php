<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Services\ProgramService;

class ProgramServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $user = null;

    private $classPath = '\App\Http\Services\ProgramService';

    public function setUp()
    {
        parent::setUp();
        $this->service = new ProgramService();

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('ProjectSeeder');
        $this->seed('LocationSeeder');
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_create()
    {
        $orgId = $this->user->organization_id;
        $displayName = "displayName";

        $response = $this->service->create($orgId, $displayName);
        dd($response);
        // dd($response);
    }
}
