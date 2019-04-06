<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed;
use App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered;

use App\Services\UserInvitationService;
use App\Services\RegisterService;


use App\User;
use App\Models\Organization;
use App\Models\Role;
use \App\Models\UserInvitation;

class UserInvitationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $user;
    private $role;
    private $classPath = 'App\Services\UserInvitationService';


    public function setUp()
    {
        parent::setUp();
        $this->registerService = new RegisterService();
        $this->service = new UserInvitationService();
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->user = User::first();
        $this->role = Role::where('name', 'Employee')->first();
        $this->actingAs($this->user);

        $name = "tes3t@email.com";
        $email = "tes3t@email.com";
        $password = "tes3t@email.com";
        $inviteCode = "000-000";
        $registerResponse = $this->registerService->register($name, $email, $password, $inviteCode);
    }

    /**
     * User Invitation Service
     *
     * @return json
     */
    public function test_user_invitation_service()
    {
        $userId = $this->user->id;
        $userId = $this->user->name;
        $name = "John Goober";
        $email = "j0hNGewB3r@email.com";
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 1;

        $response = $this->service->inviteNewUser($userId, $roleId, $name, $email);

        $this->assertArrayHasKey('email', $response);
    }

    public function test_user_invite_service_deletes_row_same_email()
    {
        $orgId = Organization::first()->id;
        $name = 'John Booger';
        $email = 'tony@tony.com';
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 3;

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $previousInviteCode = UserInvitation::where('email', $email)->first()['invite_code'];

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $newInviteCode = UserInvitation::where('email', $email)->first()['invite_code'];

        $this->assertNull(UserInvitation::where('invite_code', $previousInviteCode)->first());

        $this->assertNotEquals($previousInviteCode, $newInviteCode);
    }

    public function test_user_invite_service_thows_error_registered_email()
    {

        $orgId = Organization::first()->id;
        $name = 'John Booger';
        $email = "tes3t@email.com";
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 3;

        $this->expectException('App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered');

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('message_error', $response);
    }
}
