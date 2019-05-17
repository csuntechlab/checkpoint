<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Services\ProgramService;
use App\Models\Program;

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
        $this->seed('ProgramSeeder');
        $this->seed('LocationSeeder');
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_program_create_success()
    {
        $orgId = $this->user->organization_id;
        $displayName = "displayName";

        $response = $this->service->create($orgId, $displayName);
        $this->assertEquals($displayName, $response->display_name);
        $this->assertNotNull($response->display_name);
        $this->assertNotNull($response->id);
    }

    public function test_program_all_success()
    {
        $orgId = $this->user->organization_id;

        $response = $this->service->all($orgId);
        $this->assertNotNull($response[0]->display_name);
        $this->assertNotNull($response[0]->id);
    }

    public function test_program_allWithLocation_success()
    {
        $orgId = $this->user->organization_id;
        $response = $this->service->allWithLocation($orgId);
        $this->assertNotNull($response[0]->display_name);
        $this->assertNotNull($response[0]->id);
        $this->assertNotNull($response[0]['location']);
    }

    public function test_program_update_success()
    {
        $displayName = "display-Name_New";
        $orgId = $this->user->organization_id;
        $program = Program::where('organization_id', $orgId)->first();
        $response = $this->service->update($program, $displayName);
        $this->assertEquals($displayName, $response->display_name);
        $this->assertNotNull($response->display_name);
        $this->assertNotNull($response->id);
    }

    public function test_program_delete_success()
    {
        $expectedResponse = ["message" => "Program was deleted."];
        $orgId = $this->user->organization_id;
        $program = Program::where('organization_id', $orgId)->first();
        $response = $this->service->delete($program);
        $this->assertEquals($response, $expectedResponse);
    }

    public function test_program_create_fail()
    {
        $displayName = "display-Name_New";
        $orgId = $this->user->organization_id;
        $response = $this->service->create($orgId, $displayName);
        $this->expectException(\App\Exceptions\ProgramExceptions\DuplicateProgramName::class);
        $response = $this->service->create($orgId, $displayName);
    }
}
