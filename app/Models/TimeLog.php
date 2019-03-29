<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['id', 'user_id', 'date', 'time_sheet_id', 'clock_in', 'clock_out', 'log_change_stack'];
    public $incrementing = false;
}
