<?php

namespace App\Interfaces;

interface PaymentInterface
{
    public function createPayment(string $cardNumber);
}
