<?php
namespace App\ModelRepositories;

// Models
use App\Models\PayPeriodType;

// Interface
use App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface;


class PayPeriodTypeModelRepository implements PayPeriodTypeModelRepositoryInterface
{

    public function getPayPeriodName(string $payPeriodTypeId): string
    {
        $payPeriodType = PayPeriodType::where('id', $payPeriodTypeId)->firstOrFail();
        return $payPeriodType->name;
    }
}
