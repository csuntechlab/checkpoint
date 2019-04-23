<?php
namespace App\ModelRepositories;

// Models
use App\Models\PayPeriodType;

// Interface
use App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface;


class PayPeriodTypeModelRepository implements PayPeriodTypeModelRepositoryInterface
{

    private function getPayPeriodName(string $payPeriodTypeId)
    {
        $payPeriodType = PayPeriodType::where('id', $payPeriodTypeId)->firstOrFail();
        return $payPeriodType->name;
    }

    public function isPayPeriodType(string $typeName, string $payPeriodTypeId): bool
    {
        $payPeriodName = $this->getPayPeriodName($payPeriodTypeId);
        return $payPeriodName == $typeName;
    }
}
