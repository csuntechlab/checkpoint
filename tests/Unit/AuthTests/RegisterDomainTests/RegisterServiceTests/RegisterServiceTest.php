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
    }
    /**
     * register service test
     *
     * @return json
     */
    public function test_register_service()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com"
        ];

        $response = $this->service->register($input);

        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
    }
}
