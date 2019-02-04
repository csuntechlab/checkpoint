<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginDomain\LoginController;
use App\Http\Controllers\Api\Auth\LoginDomain\Contracts\LoginContract;


class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(LoginContract::class);
        $this->controller = new LoginController($this->retriever);
        // $this->assertDatabaseHas('oauth_clients', [
        //     'id' => '1',
        //     'user_id' => null,
        //     'name' => 'Laravel Password Grant Client',
        //     'secret' => 'secret',
        //     'redirect' => 'http ://localhost',
        //     'personal_access_client' => 0,
        //     'password_client' => 1,
        //     'revoked' => 0,
        //     'created_at' => '2019-02-01 18:13:23',
        //     'updated_at' => '2019-02-01 18:13:23',
        // ]);
    }


    /**
     * A Mockery Test for Login Contoller
     *
     * @return json
     */
    public function test_login_controller_with_mockery()
    {
        $input = ["username" => "tes3t@email.com", "password" => "tes3t@email.com"];

        $request = new Request($input);

        $expectedResponse = [
            "token_type" => "Bearer", "expires_in" => 31536000, "access_token" => "serializedToken", "refresh_token" => "serializedToken"
        ];

        $this->retriever
            ->shouldReceive('login')
            ->with($request)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->login($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_login_controller_http()
    {
        $user = factory(\App\User::class)->make();
        $insert = \DB::insert(
            'insert into oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked ) 
            values (?, ?, ?, ?, ?, ?, ?, ?)',
            [1, null, 'Laravel Password Grant Client', config('services.passport.client_secret'), 'http ://localhost', 0, 1, 0]
        );

        dd($insert);

        // $input = ['username' => $user->email, 'password' => $user->password];

        // $response = $this->json('POST', "/api/login", $input);

        // dd($response);

        // $response = $response->getOriginalContent();

        // $response = json_encode($response);

        // dd($response);

        // $expectedResponse = [
        //     "token_type" => "Bearer", "expires_in" => 31536000, "access_token" => "serializedToken", "refresh_token" => "serializedToken"
        // ];

        // $actualResponse = json_encode($actualResponse);
        // $this->assertEquals($response, $actualResponse);
        // $this->assertEquals($expectedResponse, $response);
    }
}
