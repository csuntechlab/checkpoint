<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSetting extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'organization_id';

    protected $fillable = [
        'organization_id', 'pay_period_type_id', 'time_calculator_type_id', 'categories'
    ];

    protected $hidden = ['organization_id'];

    public function isCompleted()
    {
        $payPeriodTypeId = $this->pay_period_type_id !== null;
        $categories =  $this->categories !== null;

        // TODO: Remove once time calculator is being worked on
        return  $payPeriodTypeId && $categories;

        $timeCalculatorTypeId = $this->time_calculator_type_id !== null;

        return  $payPeriodTypeId && $categories && $timeCalculatorTypeId;
    }
}
