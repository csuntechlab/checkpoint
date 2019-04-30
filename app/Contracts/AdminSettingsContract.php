<?php
namespace App\Contracts;

use App\Models\OrganizationSetting;

interface AdminSettingsContract
{
    public function currentOrganizationSettings($organizationId);
}
