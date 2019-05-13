<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\UserService;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;
    private $classPath = 'App\Services\UserService';

    public function setUp()
    {
        parent::setUp();
        $this->service = new UserService();
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder'); //seeds org and settings
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('ProjectSeeder'); // seeds also UserProject table
        $this->seed('LocationSeeder');
        $this->seed('UserInvitationsTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_profile()
    {
        $response = $this->service->profile($this->user->id);

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('userLocation', $response);
        $this->assertArrayHasKey('userProject', $response);
        $this->assertArrayHasKey('role', $response);

        $userProject = $response->userProject[0];

        $this->assertArrayHasKey('display_name', $userProject);
        $this->assertArrayHasKey('users', $userProject);

        $mentors = $userProject->users[0];

        $this->assertArrayHasKey('name', $mentors);
        $this->assertArrayHasKey('email', $mentors);
        $this->assertArrayHasKey('role', $mentors);

        $role = $mentors->role[0];

        $this->assertArrayHasKey('name', $role);
        $this->assertEquals('Mentor', $role->name);

        $userLocation = $response->userLocation[0];

        $this->assertArrayHasKey('address', $userLocation);
        $this->assertArrayHasKey('lat', $userLocation);
        $this->assertArrayHasKey('lng', $userLocation);
        $this->assertArrayHasKey('radius', $userLocation);
    }
}
