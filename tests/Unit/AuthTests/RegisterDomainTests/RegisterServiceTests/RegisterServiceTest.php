<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\Auth\RegisterDomain\Services\RegisterService;

class RegisterServiceTest extends TestCase
{
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

        $expectedResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "updated_at" => "2019-01-28 17:55:46",
            "created_at" => "2019-01-28 17:55:46",
            "id" => 3
        ];

        $response = $this->service->register($input);

        // dd($response);

    }
}
