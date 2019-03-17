<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Api\Auth\RegisterDomain\Services\RegisterService;

class RegisterServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new RegisterService();
        $this->seed('OrgnaizationSeeder');
    }
    /**
     * register service test
     *
     * @return json
     */
    public function test_register_service()
    {
        $name = "tes3t@email.com";
        $email = "tes3t@email.com";
        $password = "tes3t@email.com";
        $inviteCode = "000-000";

        $response = $this->service->register($name, $email, $password, $inviteCode);

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
    }

    // public function test_register_service_fails_throws_an_exception_undefined_index()
    // {
    //     $name = null;
    //     $email = "tes3t@email.com";
    //     $password = "tes3t@email.com";
    //     $inviteCode = "000-000";

    //     $this->expectException('App\Exceptions\AuthExceptions\UserCreatedFailed');

    //     $response = $this->service->register($name, $email, $password, $inviteCode);

    //     $this->assertArrayHasKey('message_error', $response);
    // }
}
