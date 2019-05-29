<?php
namespace App\Contracts;

interface TimeSheetContract
{
    public function getTimeSheetbyDate($date);
    public function getCurrentTimeSheet();
    public function getTimeSheetsByOrganization($organization_id);
}
