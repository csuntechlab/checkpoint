<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Api\Auth\LogoutDomain\Services\LogoutService;

class LogoutServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new LogoutService();
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

        factory(Organization::class)->create();

        $user = factory(User::class)->create();

        $expectedResponse = response()->json("Logout was succesful!");

        $this->actingAs($user);

        $response = $this->service->logout($request);

        $this->assertEquals($expectedResponse, $response);
    }
}
