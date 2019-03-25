<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Api\UserInvitation\Services\UserInvitationService;
use App\Exceptions\UserInvitationExceptions\UserInviteCreatedFailed;
use App\Models\Organization;
use App\Models\Role;
class UserInvitationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new UserInvitationService();
        $this->seed('OrganizationSeeder');
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

        $this->assertArrayHasKey('invite_code', $response);
    }

    public function test_user_invite_service_throws_exception_undefined_index()
    {
        $orgId = Organization::first()->id;
        $name = 'John Booger';
        $email = null;
        // TODO: Tony - grabbing from roles table not working for some reason
        $roleId = 3;

        $this->expectException('App\Exceptions\UserInvitationExceptions\UserInviteCreatedFailed');

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('message_error', $response);
    }
}
