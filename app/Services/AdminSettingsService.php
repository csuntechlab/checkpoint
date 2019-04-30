<?php
namespace App\Services;

use App\Contracts\AdminSettingsContract;

// Interfaces
use App\ModelRepositoryInterfaces\OrganizationSettingModelRepositoryInterface;

class AdminSettingsService implements AdminSettingsContract
{

    protected $organizationSettingsMoRepo;
    public function __construct(OrganizationSettingModelRepositoryInterface $organizationSettingsModelRepositoryInterface)
    {
        $this->organizationSettingsMoRepo = $organizationSettingsModelRepositoryInterface;
    }
    public function createOrganizationSetting($orgId, $categoriesOptIn, $payPeriodTypeId, $timeCalculatorTypeId)
    {
        return $this->organizationSettingsMoRepo->create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn);
    }
}
