<?php
namespace App\ModelRepositories;

// Models
use App\Models\PayPeriodType;

// Interface
use App\ModelRepositoryInterfaces\PayPeriodTypeModelRepositoryInterface;


class PayPeriodTypeModelRepository implements PayPeriodTypeModelRepositoryInterface
{
    public function getPayPeriodTypeById(string $payPeriodTypeId): PayPeriodType
    {
        return PayPeriodType::where('id', $payPeriodTypeId)->first();
    }
}
