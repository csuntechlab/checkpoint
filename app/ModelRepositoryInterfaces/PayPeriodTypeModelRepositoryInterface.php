<?php
namespace App\ModelRepositoryInterfaces;

use App\Models\PayPeriodType;

interface PayPeriodTypeModelRepositoryInterface
{
    public function getPayPeriodTypeById(string $payPeriodTypeId): PayPeriodType;
}
