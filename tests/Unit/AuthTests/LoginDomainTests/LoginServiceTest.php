<?php

namespace Tests\Feature;


use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;
use App\Models\Program;
use App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService;
// use App\Http\Requests\Auth\LoginRequest;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;


class LoginServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $mockedService;
    private $service;
    private $user;
    private $classPath = "App\Http\Controllers\Api\Auth\LoginDomain\Services\LoginService";

    public function setUp()
    {
        parent::setUp();
        $this->seed('PassportSeeder');
        $this->seed('OrgnaizationSeeder');
        $this->seed('ProgramSeeder');
        $this->seed('UsersTableSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
        $this->mockedService = Mockery::mock(LoginService::class);
        $this->service = new LoginService();
    }


    /**
     * A Mockery Test for Login Service
     *
     * @return json
     */
    public function test_login_service_with_mockery()
    {
        $email = "tes3t@email.com";
        $password = "tes3t@email.com";

        $expectedResponse = [
            "token_type" => "Bearer",  "access_token" => "serializedToken"
        ];

        $this->mockedService
            ->shouldReceive('login')
            ->with($email, $password)
            ->once()->andReturn($expectedResponse);

        $response = $this->mockedService->login($email, $password);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_login_service_authenticate_user_pass()
    {
        $email = "example@emai.com";
        $password = $email;
        $programId = Program::first();
        $programId = $programId->id;

        User::create([
            'name' => $email,
            'email' => $email,
            'password' => Hash::make($password),
            'program_id' => $programId
        ]);

        $function = 'authenticateUser';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $email, $password);

        $this->assertInstanceOf('App\User', $response);
    }

    public function test_login_service_create_token_pass()
    {
        $function = 'createToken';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $this->user);
        $this->assertArrayHasKey('access_token', $response);
        $this->assertArrayHasKey('token_type', $response);
        $this->assertNotNull($response['access_token']);
        $this->assertNotNull($response['token_type']);
    }
}
