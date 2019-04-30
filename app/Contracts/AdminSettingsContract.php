<?php
namespace App\Contracts;

use App\Models\OrganizationSetting;

interface AdminSettingsContract
{
    public function currentOrganizationSettings($organizationId);

    public function updateCategories($organizationId, $categoriesOptIn);

    public function updatePayPeriod($organizationId, $payPeriodTypeId);
}
