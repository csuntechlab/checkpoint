<?php
namespace App\Contracts;

interface AdminSettingsContract
{
    public function getOrganizationSettings($organizationId);

    public function updateCategories($organizationId, $categoriesOptIn);

    public function updatePayPeriod($organizationId, $payPeriodTypeId);
}
