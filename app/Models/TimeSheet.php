<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [];

    public function scopeGetTimeSheet($query, $date, $id)
    {
        return $query->where('organization_id', $id)
        ->where('start_date', '<=', $date)
        ->where('end_date', '>=', $date);
    }

    public function scopeGetTimeSheetsByOrganization($query, $organizaiton_id)
    {
        return $query->select('id', 'organization_id', 'start_date', 'end_date')
        ->where('organization_id', $organizaiton_id);
    }
}
