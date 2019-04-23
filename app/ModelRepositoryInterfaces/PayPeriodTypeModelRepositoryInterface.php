<?php
namespace App\ModelRepositoryInterfaces;


interface PayPeriodTypeModelRepositoryInterface
{
    public function isPayPeriodType(string $typeName, string $payPeriodTypeId): bool;
}
