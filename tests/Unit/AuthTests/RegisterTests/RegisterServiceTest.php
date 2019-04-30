<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Services\RegisterService;
use App\Models\UserInvitation;

// Invitations
use App\ModelRepositoryInterfaces\UserModelRepositoryInterface;

class RegisterServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    private $classPath = '\App\Services\RegisterService';

    public function setUp()
    {
        parent::setUp();
        $this->modelInterface = Mockery::mock(UserModelRepositoryInterface::class);
        $this->service = new RegisterService($this->modelInterface);
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder'); //seeds org and settings
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('ProjectSeeder'); // seeds also UserProject table
        $this->seed('LocationSeeder');
        $this->seed('UserInvitationsTableSeeder');
    }
    /**
     * register service test
     *
     * @return json
     */
    public function test_register_service()
    {
        $userInvitation = UserInvitation::all()->random();

        $name = $userInvitation->name;
        $email = $userInvitation->email;
        $password = "tes3t@email.com";
        $inviteCode = $userInvitation->invite_code;

        $expectedResponse = [
            "user" => [
                "name" => $name,
                "email" => $email
            ],
            "role" => [
                "name" => "Employee"
            ]
        ];

        $this->modelInterface
            ->shouldReceive('create')
            ->with($name, $email, $password, $userInvitation->organization_id, $userInvitation->role_id)
            ->once()->andReturn($expectedResponse);

        $response = $this->service->register($name, $email, $password, $inviteCode);

        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('name', $response['user']);
        $this->assertArrayHasKey('email', $response['user']);
        $this->assertArrayHasKey('role', $response);
        $this->assertArrayHasKey('name', $response['role']);
    }

    public function test_getOrganizationIdByUserInvitation()
    {
        $userInvitation = UserInvitation::all()->random();

        $name = $userInvitation->name;
        $email = $userInvitation->email;
        $password = "tes3t@email.com";
        $inviteCode = $userInvitation->invite_code;

        $function = 'getOrganizationIdByUserInvitation';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $email, $inviteCode);

        $this->assertNotNull($response);
        $this->assertEquals($userInvitation, $response);
        $this->assertInstanceOf(UserInvitation::class, $response);
    }
}
