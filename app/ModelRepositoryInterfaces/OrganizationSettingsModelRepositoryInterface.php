<?php
namespace App\ModelRepositoryInterfaces;


interface OrganizationSettingsModelRepositoryInterface
{
    public function create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn);
}
