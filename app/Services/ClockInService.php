<?php
namespace App\Services;

// Domain Value Objects
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeSheet;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts
use App\Contracts\ClockInContract;
use App\ModelRepositoryInterfaces\TimeLogClockInModelRepositoryInterface;
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\Models\TimeLog;
use App\Exceptions\TimeLogExceptions\ClockIn\ClockInWasNotSuccessfullyAdded;

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

        $clockIn = new TimeStamp($date, $time);

        $clockIn->isWithInStartAndEndDate($timeSheet->start_date, $timeSheet->end_date);
        $clockIn = $clockIn->toArray();

        $timeSheetId = $timeSheet->id;


        $timeLogId = UUID::generate();
        $date = $clockIn['date'];
        $time = $clockIn['time'];
        $clockIn = json_encode($clockIn);
        try {
            TimeLog::create([
                'id' => $timeLogId,
                'user_id' => $userId,
                'organization_id' => $organizationId,
                'time_sheet_id' => $timeSheetId,
                'date' => $date,
                'clock_in' => $clockIn
            ]);
        } catch (\Exception $e) {
            throw new ClockInWasNotSuccessfullyAdded;
        }

        return [
            "message_success" => "Clock in was successful",
            "time_sheet_id" => $timeSheetId,
            "log_id" => $timeLogId,
            "date" => $date,
            "time" => $time
        ];
    }
}
