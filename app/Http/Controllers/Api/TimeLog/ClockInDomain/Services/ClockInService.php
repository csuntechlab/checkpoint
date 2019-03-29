<?php
namespace App\Http\Controllers\Api\TimeLog\ClockInDomain\Services;

// Auth

use Illuminate\Support\Facades\Auth;

// Contracts
use App\Http\Controllers\Api\TimeLog\ClockInDomain\Contracts\ClockInContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockInLogicContract;

class ClockInService implements ClockInContract
{
    protected $clockInLogicUtility;

    public function __construct(ClockInLogicContract $clockInLogicUtility)
    {
        $this->clockInLogicUtility = $clockInLogicUtility;
    }

    public function clockIn(string $date, string $time): array
    {
        $user = Auth::user();
        $userId = $user->id;
        $organizationId = $user->organization_id;

        $this->clockInLogicUtility->userHasIncompleteTimeLogByDate($date, $userId);

        $logParam = $this->clockInLogicUtility->getTimeLogParam($userId, $date, $time);

        return $this->clockInLogicUtility->createClockInEntry($logParam['id'], $userId, $organizationId, $logParam['timeSheetId'], $logParam['clockIn'], $date, $time);
    }
}
