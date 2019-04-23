<?php
namespace App\ModelRepositories;

// Models
use App\Models\OrganizationSettings;
use App\DomainValueObjects\UUIDGenerator\UUID;

// Interface
use App\ModelRepositoryInterfaces\OrganizationSettingsModelRepositoryInterface;


class OrganizationSettingsModelRepository implements OrganizationSettingsModelRepositoryInterface
{
    public function create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn)
    {
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
