<?php
namespace App\Contracts;

interface AdminSettingsContract
{
    public function createOrganizationSettings(
        $orgId,
        $categoriesOptIn,
        $payPeriodTypeId,
        $timeCalculatorTypeId
    );
}
