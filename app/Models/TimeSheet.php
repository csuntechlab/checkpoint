<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'organization_id'
    ];

    public function scopeGetCurrentTimesheet($query, $date, $id)
    {
        return $query->where('organization_id', $id)
        ->where('start_date', '<=', $date)
        ->where('end_date', '>=', $date);
    }
}
