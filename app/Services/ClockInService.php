<?php
namespace App\Services;

// Domain Value Objects TimeStamp
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

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

        // Verify user does not have incomplete time log 
        $this->clockInModelRepo->userHasIncompleteTimeLogByDate($date, $userId);
        // Get Time Sheet 
        $timeSheet = $this->clockInModelRepo->getTimeSheet($organizationId);

        $timeStamp = new TimeStamp($date, $time);

        $timeStamp->isWithInStartAndEndDate($timeSheet->start_date, $timeSheet->end_date);

        return $this->clockInModelRepo->createClockInEntry($userId, $organizationId, $timeSheet->id, $timeStamp);
    }
}
