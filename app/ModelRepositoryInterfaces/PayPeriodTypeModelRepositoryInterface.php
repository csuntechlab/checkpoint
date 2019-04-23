<?php
namespace App\ModelRepositoryInterfaces;


interface PayPeriodTypeModelRepositoryInterface
{
    public function getPayPeriodName(string $payPeriodTypeId): string;
}
