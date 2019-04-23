<?php
namespace App\Services;

use App\Contracts\AdminSettingsContract;

// Auth
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\PayPeriodType;
use App\Models\OrganizationSettings;
use App\DomainValueObjects\UUIDGenerator\UUID;

class AdminSettingsService implements AdminSettingsContract
{
    public function setOrganizationSettings($categoriesOptIn, $payPeriodTypeId, $timeCalculatorTypeId, $startDate)
    {
        $admin = Auth::user();
        $orgId = $admin->organization_id;

        try {
            $settings = OrganizationSettings::create([
                'id' => UUID::generate(),
                'organization_id' => $orgId,
                'pay_period_type_id' => $payPeriodTypeId,
                'time_calculator_type_id' => $timeCalculatorTypeId,
                'categories' => $categoriesOptIn
            ]);
        } catch (\Exception $e) {
            dd($e);
        }


        return $settings;
    }
}
