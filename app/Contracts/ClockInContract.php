<?php
namespace App\Contracts;

interface ClockInContract
{
    public function clockIn(string $date, string $time): array;
}
