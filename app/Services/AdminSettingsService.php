<?php
namespace App\Services;

use App\Contracts\AdminSettingsContract;

// Interfaces
use App\ModelRepositoryInterfaces\OrganizationSettingsModelRepositoryInterface;

class AdminSettingsService implements AdminSettingsContract
{

    protected $organizationSettingsMoRepo;
    public function __construct(OrganizationSettingsModelRepositoryInterface $organizationSettingsModelRepositoryInterface)
    {
        $this->organizationSettingsMoRepo = $organizationSettingsModelRepositoryInterface;
    }
    public function createOrganizationSettings($orgId, $categoriesOptIn, $payPeriodTypeId, $timeCalculatorTypeId)
    {
        return $this->organizationSettingsMoRepo->create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn);
    }
}
