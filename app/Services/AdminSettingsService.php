<?php
namespace App\Services;

use App\Contracts\AdminSettingsContract;

// Interfaces
use App\ModelRepositoryInterfaces\OrganizationSettingModelRepositoryInterface;

// Models
use App\Models\OrganizationSetting;
use App\Models\PayPeriodType;
use App\Models\TimeCalculatorType;

class AdminSettingsService implements AdminSettingsContract
{

    protected $organizationSettingsMoRepo;
    public function __construct(OrganizationSettingModelRepositoryInterface $organizationSettingsModelRepositoryInterface)
    {
        $this->organizationSettingsMoRepo = $organizationSettingsModelRepositoryInterface;
    }
    public function currentOrganizationSettings($organizationId)
    {
        $organizationSetting  = OrganizationSetting::where('organization_id', $organizationId)->first();
        $payPeriodType = PayPeriodType::all();
        // $payPeriodType = TimeCalculatorType::all();
        return compact(['organizationSetting', 'payPeriodType']);
    }
}
