<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Requests
use App\Http\Requests\DisplayNameRequest;

// Models
use App\Models\Category;

//Contracts
use App\Contracts\CategoriesContract;

// Controllers
use App\Http\Controllers\CategoriesController;

class CategoriesControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;
    private $user = null;

    private $classPath = '\App\Http\Controllers\CategoriesController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(CategoriesContract::class);
        $this->controller = new CategoriesController($this->utility);

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('CategorySeeder'); // seeds also UserCategory table
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_category_controller_create()
    {
        $input = ['display_name' => 'display'];
        $request = new DisplayNameRequest($input);

        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('createCategory')
            ->once()
            ->with($orgId, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->createCategory($request);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_category_controller_all()
    {
        $expectedResponse = [
            [
                "id" => "id",
                "display_name" => "ChecKpoint---",
            ],
            [
                "id" => "id",
                "display_name" => "Tiana Roberts",
            ],
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('allCategory')
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->allCategory();
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_category_controller_update()
    {
        $input = ['display_name' => 'display'];
        $request = new DisplayNameRequest($input);

        $category = Category::where('organization_id', $this->user->organization_id)->first();


        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('updateCategory')
            ->once()
            ->with($category, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->updateCategory($request, $category);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_category_controller_delete()
    {
        $category = Category::where('organization_id', $this->user->organization_id)->first();

        $expectedResponse = [
            "message" => 'Category was deleted.',
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('deleteCategory')
            ->once()
            ->with($category)
            ->andReturn($expectedResponse);

        $response = $this->controller->deleteCategory($category);
        $this->assertEquals($expectedResponse, $response);
    }
}
