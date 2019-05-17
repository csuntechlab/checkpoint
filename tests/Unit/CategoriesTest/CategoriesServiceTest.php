<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Services\CategoriesService;
use App\Models\Categories;
use App\Models\Category;

class CategoriesServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $service;
    private $user = null;

    private $classPath = '\App\Http\Services\CategoriesService';

    public function setUp()
    {
        parent::setUp();
        $this->service = new CategoriesService();

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('CategorySeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('CategorySeeder');
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }


    public function test_categories_create_success()
    {
        $orgId = $this->user->organization_id;
        $displayName = "displayName";

        $response = $this->service->createCategory($orgId, $displayName);
        $this->assertEquals($displayName, $response->display_name);
        $this->assertNotNull($response->display_name);
        $this->assertNotNull($response->id);
    }

    public function test_categories_all_success()
    {
        $orgId = $this->user->organization_id;

        $response = $this->service->allCategory($orgId);
        $this->assertNotNull($response[0]->display_name);
        $this->assertNotNull($response[0]->id);
    }

    public function test_categories_update_success()
    {
        $displayName = "display-Name_New";
        $orgId = $this->user->organization_id;
        $category = Category::where('organization_id', $orgId)->first();
        $response = $this->service->updateCategory($category, $displayName);
        $this->assertEquals($displayName, $response->display_name);
        $this->assertNotNull($response->display_name);
        $this->assertNotNull($response->id);
    }

    public function test_categories_delete_success()
    {
        $expectedResponse = ["message" => "Category was deleted."];
        $orgId = $this->user->organization_id;
        $category = Category::where('organization_id', $orgId)->first();
        $response = $this->service->deleteCategory($category);
        $this->assertEquals($response, $expectedResponse);
    }

    public function test_categories_create_fail()
    {
        $displayName = "display-Name_New";
        $orgId = $this->user->organization_id;
        $response = $this->service->createCategory($orgId, $displayName);
        $this->expectException(\App\Exceptions\DuplicateName::class);
        $response = $this->service->createCategory($orgId, $displayName);
    }
}
