<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed;
use App\Exceptions\UserInvitationExceptions\UserAlreadyRegistered;

use App\Http\Controllers\Api\UserInvitation\Services\UserInvitationService;
use App\Http\Controllers\Api\Auth\RegisterDomain\Services\RegisterService;

use App\User;
use App\Models\Organization;
use App\Models\Role;
use App\Models\UserInvitation;

class UserInvitationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\UserInvitation\Services\UserInvitationService';


    public function setUp()
    {
        parent::setUp();
        $this->registerService = new RegisterService();
        $this->service = new UserInvitationService();
        $this->seed('OrganizationSeeder');
        $this->seed('ProgramSeeder');

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
        $orgId = Organization::first()->id;
        $name = "John Goober";
        $email = "j0hNGewB3r@email.com";
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 3;

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('email', $response);
    }

    public function test_user_invite_service_throws_exception_undefined_index()
    {
        $orgId = Organization::first()->id;
        $name = 'John Booger';
        $email = null;
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 3;

        $this->expectException('App\Exceptions\UserInvitationExceptions\UserInviteCreationFailed');

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('message_error', $response);
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

    public function test_verifyUserIsNotAlreadyRegistered_returns_false_registed_email()
    {
        $email = "tes3t@email.com";

        $function = 'verifyUserIsNotAlreadyRegistered';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $email);
        $this->assertEquals($response, false);

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
