<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Api\UserInvitation\Services\UserInvitationService;

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
     * register service test
     *
     * @return json
     */
    public function test_user_invitation_service()
    {
        $orgId = Organization::first();
        $roleId = Role::where('name', 'Employee')->first()->id;
        $name = "John Goober";
        $email = "j0hNGewB3r@email.com";


        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('invite_code', $response);
    }

    public function test_user_invite_service_throws_exception_undefined_index()
    {
        $orgId = Organization::first();
        $roleId = Role::where('name', 'Employee')->first()->id;
        $name = 'John Booger';
        $email = null;

        $this->expectException('App\Exceptions\AuthExceptions\UserInviteCreationFailed');

        $response = $this->service->inviteNewUser($orgId, $roleId, $name, $email);

        $this->assertArrayHasKey('message_error', $response);
    }
}
