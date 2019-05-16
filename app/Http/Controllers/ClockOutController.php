<?php
namespace App\Http\Controllers;

// Auth
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

// Request
use App\Http\Requests\ClockRequest;

// Models
use App\User;
use App\Models\TimeLog;

// Contract
use App\Contracts\ClockOutContract;

class ClockOutController extends Controller
{
    protected $clockOutUtility;

    public function __construct(ClockOutContract $clockOutContract)
    {
        $this->clockOutUtility = $clockOutContract;
    }

    public function clockOut(ClockRequest $request, TimeLog $timeLog): array
    {
        (Auth::user())->authorizeTimeLog($timeLog);
        return $this->clockOutUtility->clockOut($request['date'], $request['time'], $timeLog);
    }
}
