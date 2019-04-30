<?php
namespace App\ModelRepositories;

// Models
use App\Models\OrganizationSetting;
use App\DomainValueObjects\UUIDGenerator\UUID;

// Interface
use App\ModelRepositoryInterfaces\OrganizationSettingModelRepositoryInterface;

// Exceptions
use App\Exceptions\OrganizationExceptions\OrganizationSettingHasEntryException;

class OrganizationSettingModelRepository implements OrganizationSettingModelRepositoryInterface
{
    public function create($orgId, $payPeriodTypeId, $timeCalculatorTypeId, $categoriesOptIn)
    {
        try {
            $settings = OrganizationSetting::create([
                'id' => UUID::generate(),
                'organization_id' => $orgId,
                'pay_period_type_id' => $payPeriodTypeId,
                'time_calculator_type_id' => $timeCalculatorTypeId,
                'categories' => $categoriesOptIn
            ]);
        } catch (\Exception $e) {
            throw new OrganizationSettingHasEntryException();
        }
        return $settings;
    }
}
