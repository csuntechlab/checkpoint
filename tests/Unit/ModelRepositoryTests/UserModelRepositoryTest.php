<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\ModelRepositories\UserModelRepository;
use App\Models\Organization;
use App\User;
use App\Models\Role;

class UserModelRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    private $clockInLogicUtility;
    private $service;
    private $classPath = 'App\Services\ClockInService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->modelRepository = new UserModelRepository();
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_admin_user()
    {
        $name = 'John Doe';
        $email = 'JohnDoe@email.com';
        $password = 'secret';
        $organizationId = (Organization::all()->random())->id;
        $roleAdminId = 1;
        $response = $this->modelRepository->create($name,  $email,  $password, $organizationId, $roleAdminId);
        // dd($response);
        $this->assertNotNull($response);
        $this->assertInstanceOf(User::class, $response['user']);
        $this->assertInstanceOf(Role::class, $response['role']);
    }
}
