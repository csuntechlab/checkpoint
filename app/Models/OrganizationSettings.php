<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSettings extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id', 'organization_id', 'pay_period_type_id', 'time_calculator_type_id', 'categories'
    ];
}
