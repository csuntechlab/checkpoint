<?php

namespace Tests\Feature;

use Tests\TestCase;

// Service
use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockOutLogicService;

class ClockOutLogicServiceNoDatabaseMigrationsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockOutLogicService();
    }

    public function test_get_time_log_throws_database_query_failed()
    {
        $userId = 1;
        $this->expectException('App\Exceptions\GeneralExceptions\DataBaseQueryFailed');
        $uuid = 'uuid';
        $this->service->getTimeLog($userId, $uuid);
    }
}
