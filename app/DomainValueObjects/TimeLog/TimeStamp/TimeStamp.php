<?php

declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\TimeStamp;

use App\Exceptions\TimeLogExceptions\TimeStamp\GenerateTimeStampFailed;
use Carbon\Carbon;


class TimeStamp
{
    private $timeZone = 'America/Los_Angeles';
    private $date = null;
    private $time = null;
    public $carbon = '';

    public function __construct(string $date = null, string $time = null)
    {
        $this->date = $date;
        $this->time = $time;
        $this->validation();
        $this->carbon = $this->toCarbon($this->__toString());
    }

    private function validation()
    {
        $dateBool = $this->date == null || $this->date == '';

        $timeBool = $this->time == null || $this->time == '';

        if ($dateBool || $timeBool) throw new GenerateTimeStampFailed();
    }

    public function __toString(): string
    {
        return $this->date . " " . $this->time;
    }

    public function toCarbon($timeStampString): Carbon
    {
        return Carbon::parse($timeStampString, $this->timeZone);
    }

    // Throw Exception if it is not apart of the time frame
    public function isWithInStartAndEndDate(string $startDate, string $endDate): bool
    {
        $startDate = $this->toCarbon($startDate);
        $endDate = $this->toCarbon($endDate);
        return $this->carbon->between($startDate, $endDate);
    }

    public function toArray(): array
    {
        $data = array();
        $data['date'] = $this->date;
        $data['time'] = $this->time;
        // $data['timeStamp'] = $this->__toString();
        return $data;
    }
}
