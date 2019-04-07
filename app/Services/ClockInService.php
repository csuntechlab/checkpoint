<?php
namespace App\Services;

// Auth

use Illuminate\Support\Facades\Auth;

// Contracts
use App\Contracts\ClockInContract;
use App\ModelRepositoryInterfaces\TimeLogClockInModelRepositoryInterface;

class ClockInService implements ClockInContract
{
    protected $clockInModelRepo;

    public function __construct(TimeLogClockInModelRepositoryInterface $clockInModelRepo)
    {
        $this->clockInModelRepo = $clockInModelRepo;
    }

    public function clockIn(string $date, string $time): array
    {
        $user = Auth::user();
        $userId = $user->id;
        $organizationId = $user->organization_id;

        $this->clockInModelRepo->userHasIncompleteTimeLogByDate($date, $userId);

        $logParam = $this->clockInModelRepo->getTimeLogParam($userId, $date, $time);
        dd($logParam);

        return $this->clockInModelRepo->createClockInEntry($logParam['id'], $userId, $organizationId, $logParam['timeSheetId'], $logParam['clockIn'], $date, $time);
    }
}
