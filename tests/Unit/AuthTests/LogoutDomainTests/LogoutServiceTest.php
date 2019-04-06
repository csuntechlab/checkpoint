<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\Api\Auth\LogoutDomain\Services\LogoutService;

class LogoutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new LogoutService();
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
    }
    /**
     * register service test
     *
     * @return json
     */
    public function test_logout_service()
    {
        $request = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer serializedToken'
        ]);

        $expectedResponse = response()->json("Logout was successful!");

        $user = \App\User::where('id', 1)->first();
        $this->actingAs($user);

        $response = $this->service->logout($request);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * logout test try-catch
     *
     * @return json
     */
    public function test_logout_validation_catches_failed_logout()
    {
        $request = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer serializedToken'
        ]);

        $response = $this->service->logout($request);

        $expectedResponse = [
            'status_code' => 403,
            'message_error' => 'Logout failed',
        ];

        $this->assertEquals($expectedResponse, $response);
    }
}
