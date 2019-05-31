<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\ProgramRequest;
use App\Http\Requests\ProgramUserRequest;
use App\Http\Requests\DisplayNameRequest;

// Models
use App\Models\PayPeriodType;
use App\Models\UserProgram;

//Contracts
use App\Contracts\ProgramContract;

// Controllers
use App\Http\Controllers\ProgramController;

// Models
use App\Models\Program;
use App\User;

class ProgramControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;
    private $user = null;

    private $classPath = '\App\Http\Controllers\ProgramController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(ProgramContract::class);
        $this->controller = new ProgramController($this->utility);

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('ProgramSeeder');
        $this->seed('UsersTableSeeder');// seeds also UserProgram table
        
        $this->user = $this->createAdminUser();
        // $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_program_controller_create()
    {
        $input = ['display_name' => 'display'];
        $request = new ProgramRequest($input);

        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('create')
            ->once()
            ->with($orgId, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->create($request);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_all()
    {
        $expectedResponse = [
            [
                "id" => "id",
                "display_name" => "ChecKpoint---",
                "location" => []
            ],
            [
                "id" => "id",
                "display_name" => "Tiana Roberts",
                "location" => [
                    [
                        "id" => "id",
                        "address" => "9061\\tLoyce Prairie\\tKoeppton\\tNevada\\t55935",
                        "lat" => "86.8767400000",
                        "lng" => "-152.9962850000",
                        "radius" => "47.00"
                    ],
                    [
                        "id" => "id",
                        "address" => "5263\\tSaige Mills\\tBreitenbergmouth\\tOhio\\t98666-2646",
                        "lat" => "18.8048100000",
                        "lng" => "173.4162610000",
                        "radius" => "39.00"
                    ]
                ]
            ],
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('all')
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->all();
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_update()
    {
        $input = ['display_name' => 'display'];
        $request = new DisplayNameRequest($input);
        
        $program = Program::where('organization_id', $this->user->organization_id)->first();


        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('update')
            ->once()
            ->with($program, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->update($request, $program);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_delete()
    {
        $program = Program::where('organization_id', $this->user->organization_id)->first();

        $expectedResponse = [
            "message" => 'Program was deleted.',
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('delete')
            ->once()
            ->with($program)
            ->andReturn($expectedResponse);

        $response = $this->controller->delete($program);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_addUser()
    {
        $user = User::all()->random();
        $program = Program::all()->random();

        $request = [
            'user_id' => $user->id,
            'program_id' => $program->id,
            'program_name' => $program->display_name
        ];

        $request = new ProgramUserRequest($request);
        
        $expectedResponse = [
            "message" => 'User was added to ' . $program->display_name . '.'
        ];

        $this->utility
            ->shouldReceive('addUser')
            ->once()
            ->with(
                $request['user_id'],
                $request['program_id'],
                $request['program_name']
                )
            ->andReturn($expectedResponse);

        $response = $this->controller->addUser($request);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_addUser_http_call()
    {
        $user = User::create([
            'organization_id' => 'OrgId',
            'name' => 'Anakin',
            'email' => 'anakin@email.com',
            'password' => 'password'
        ]);

        $program = Program::all()->random();

        $request = [
            'user_id' => $user->id,
            'program_id' => $program->id,
            'program_name' => $program->display_name
        ];
        
        $expectedResponse = [
            "message" => 'User was added to ' . $program->display_name . '.'
        ];

        $token = $this->get_auth_token($this->user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $token
        ])->json('POST', '/api/program/add/user', $request);
        $response = $response->getOriginalContent();
        
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_removeUser()
    {
        $user = User::all()->random();
        $program = Program::all()->random();

        $expectedResponse = [
            "message" => 'User was deleted from ' . $program->display_name . '.'
        ];

        $this->utility
            ->shouldReceive('removeUser')
            ->once()
            ->with($user, $program)
            ->andReturn($expectedResponse);

        $response = $this->controller->removeUser($user, $program);
        $this->assertEquals($expectedResponse, $response);
    }
}
