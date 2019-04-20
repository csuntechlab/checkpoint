<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery;

use App\Contracts\UserContract;

use App\Http\Controllers\UserController;


class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;

    private $classPath = '\App\Http\Controllers\UserController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(UserContract::class);
        $this->controller = new UserController($this->utility);

        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder'); //seeds org and settings
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('ProjectSeeder'); // seeds also UserProject table
        $this->seed('LocationSeeder');
        $this->seed('UserInvitationsTableSeeder');
        $this->seed('TimeSheetSeeder');

        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserProfile()
    {
        $name = $this->user->name;
        $email = $this->user->email;
        $role = $this->user->role;
        $expectedResponse = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'userLocation' => [["address" => "8601\\tMichale Route\\tKiehnstad\\tRhode Island\\t00675", "lat" => "-64.7822090000", "lng" => "-64.0216350000", "radius" => "13.00"], ["address" => "8601\\tMichale Route\\tKiehnstad\\tRhode Island\\t00675", "lat" => "-64.7822090000", "lng" => "-64.0216350000", "radius" => "13.00"],],
            'userProject' => [['display_name' => 'projectName', 'users' => [['name' => 'name',        'email' => 'email@email.com',        'role' => [['name' => 'mentor']]], ['name' => 'name',        'email' => 'email@email.com',        'role' => [['name' => 'mentor']]]]], ['display_name' => 'projectName', 'users' => [['name' => 'name',        'email' => 'email@email.com',        'role' => [['name' => 'mentor']]], ['name' => 'name',        'email' => 'email@email.com',        'role' => [['name' => 'mentor']]]]]],
        ];

        $expectedResponse = json_encode($expectedResponse);

        $this->utility
            ->shouldReceive('profile')
            ->once()->andReturn($expectedResponse);

        $response = $this->controller->profile();

        $this->assertEquals($response, $expectedResponse);
    }

    public function test_profile_http_call()
    {
        $token = $this->get_auth_token($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $token
        ])->json('GET', '/api/user/profile')->getOriginalContent();

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('userLocation', $response);
        $this->assertArrayHasKey('userProject', $response);
        $this->assertArrayHasKey('role', $response);

        $userProject = $response->userProject[0];

        $this->assertArrayHasKey('display_name', $userProject);
        $this->assertArrayHasKey('users', $userProject);

        $mentors = $userProject->users[0];

        $this->assertArrayHasKey('name', $mentors);
        $this->assertArrayHasKey('email', $mentors);
        $this->assertArrayHasKey('role', $mentors);

        $role = $mentors->role[0];

        $this->assertArrayHasKey('name', $role);
        $this->assertEquals('Mentor', $role->name);

        $userLocation = $response->userLocation[0];

        $this->assertArrayHasKey('address', $userLocation);
        $this->assertArrayHasKey('lat', $userLocation);
        $this->assertArrayHasKey('lng', $userLocation);
        $this->assertArrayHasKey('radius', $userLocation);
    }
}
