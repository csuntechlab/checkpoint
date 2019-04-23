<?php
namespace App\Contracts;

interface AdminSettingsContract
{
    public function setOrganizationSettings($categoriesOptIn, $payPeriodTypeId, $timeCalculatorTypeId, $startDate);
}
