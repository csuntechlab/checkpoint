<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;


use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Controllers\RegisterController;
use App\Contracts\RegisterContract;
use App\Models\UserInvitation;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;
    private $classPath = "\App\Http\Controllers\Api\Auth\RegisterDomain\RegisterController";

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(RegisterContract::class);
        $this->controller = new RegisterController($this->retriever);
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
     * A Mockery Test for Register Controller
     *
     * @return userCreds
     */
    public function test_register_controller_with_mockery()
    {

        $input['name'] = "tes3t@email.com";
        $input['email'] = "tes3t@email.com";
        $input['password'] = "tes3t@email.com";
        $input['invitation_code'] = "000-000";

        $request = new RegisterRequest($input);

        $expectedResponse = [];

        $this->retriever
            ->shouldReceive('register')
            ->with($request['name'], $request['email'], $request['password'], $request['invitation_code'])
            ->once()->andReturn($expectedResponse);

        $response = $this->controller->register($request);

        $this->assertEquals($expectedResponse, $response);
    }

    // This test sometimes fails cause of the invite code, TODO: Investigate
    public function test_register_http_call()
    {
        $userInvitation = UserInvitation::all()->random();

        $name = $userInvitation->name;
        $email = $userInvitation->email;
        $password = "tes3t@email.com";
        $inviteCode = (int)($userInvitation->invite_code);

        $input = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "password_confirmation" => $password,
            "invitation_code" => $inviteCode
        ];

        $response = $this->json('POST', "/api/register", $input);
        $response = $response->getOriginalContent();
        $response = json_encode($response);
        $actualResponse = [
            "user" => [
                "name" => $name,
                "email" => $email
            ],
            "role" => [
                "name" => "Employee"
            ]
        ];
        $actualResponse = json_encode($actualResponse);
        $this->assertEquals($response, $actualResponse);
    }

    public function test_register_fails_with_wrong_parameters()
    {
        $input = [
            "name" => "",
            "email" => "not_a_email",
            "password" => "oof",
            "password_confirmation" => "yikes",
            "invitation_code" => "123h"
        ];

        $response = $this->json('POST', "/api/register", $input);
        $response = $response->getOriginalContent();

        $expected = [
            "message" => "The given data was invalid.",
            "errors" => [
                "name" => [
                    0 => "Name is required!"
                ],
                "email" => [
                    0 => "Email is invalid."
                ],
                "password" => [
                    0 => "Password must be 6 characters long!",
                    1 => "The password confirmation does not match."
                ],
                "invitation_code" => [
                    0 => "Incorrect code!"
                ]
            ]
        ];

        $this->assertEquals($expected, $response);
    }
}
