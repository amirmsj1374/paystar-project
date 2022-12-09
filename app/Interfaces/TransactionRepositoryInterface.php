<?php

namespace App\Interfaces;

interface TransactionRepositoryInterface
{
    public function create(string $orderId, string $refNum, string $gateway, string $cardNumber);
}
