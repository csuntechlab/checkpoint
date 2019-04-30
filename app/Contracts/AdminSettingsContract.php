<?php
namespace App\Contracts;

interface AdminSettingsContract
{
    public function createOrganizationSetting(
        $orgId,
        $categoriesOptIn,
        $payPeriodTypeId,
        $timeCalculatorTypeId
    );
}
