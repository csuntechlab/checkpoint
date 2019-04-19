<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'org_id'
    ];

    public function scopeGetCurrentTimesheet($query, $date)
    {
        return $query->where('start_date', '<=', $date)
        ->where('end_date' '>=', $date);
    }
}
