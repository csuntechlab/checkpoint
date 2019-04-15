<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Services\RegisterService;
use App\Models\UserInvitation;

class RegisterServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new RegisterService();
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

        $response = $this->service->register($name, $email, $password, $inviteCode);

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
    }

    public function test_register_service_fails_throws_an_exception_undefined_index()
    {
        $userInvitation = UserInvitation::all()->random();

        $name = null;
        $email = $userInvitation->email;
        $password = "tes3t@email.com";
        $inviteCode = $userInvitation->invite_code;


        $this->expectException('App\Exceptions\AuthExceptions\UserCreatedFailed');

        $response = $this->service->register($name, $email, $password, $inviteCode);

        $this->assertArrayHasKey('message_error', $response);
    }
}
