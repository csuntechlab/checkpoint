<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = ['id', 'user_id', 'time_sheet_id', 'clock_in', 'clock_out', 'log_change_stack'];
    public $incrementing = false;
}