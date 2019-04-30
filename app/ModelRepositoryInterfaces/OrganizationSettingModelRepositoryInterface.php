<?php
namespace App\ModelRepositoryInterfaces;


interface OrganizationSettingModelRepositoryInterface
{
    public function create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn);
}
