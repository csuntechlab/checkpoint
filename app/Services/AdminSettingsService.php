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

    private function organizationSettings($organizationId)
    {
        return OrganizationSetting::where('organization_id', $organizationId)->firstOrFail();
    }

    public function currentOrganizationSettings($organizationId)
    {
        $organizationSetting  = $this->organizationSettings($organizationId);
        $payPeriodType = PayPeriodType::all();
        // $payPeriodType = TimeCalculatorType::all();
        return compact(['organizationSetting', 'payPeriodType']);
    }

    public function updateCategories($organizationId, $categoriesOptIn)
    {
        try {
            $organizationSetting  = $this->organizationSettings($organizationId);
            $organizationSetting->categories  = $categoriesOptIn;
            $organizationSetting->save();
        } catch (\Exception $e) {
            throw new OrganizationSettingEntryDidNotSave('Categories');
        }
        return $organizationSetting;
    }

    public function updatePayPeriod($organizationId, $payPeriodTypeId)
    {
        try {
            $organizationSetting  = $this->organizationSettings($organizationId);
            $organizationSetting->pay_period_type_id  = $payPeriodTypeId;
            $organizationSetting->save();
        } catch (\Exception $e) {
            throw new OrganizationSettingEntryDidNotSave('Pay Period');
        }
        return $organizationSetting;
    }
}
