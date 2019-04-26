<?php
namespace App\Contracts;

interface TimeSheetContract
{
    public function getCurrentTimeSheet($date);
}
