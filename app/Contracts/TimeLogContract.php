<?php
namespace App\Contracts;

interface TimeLogContract
{
    public function getTimeLogByDate($date);
}