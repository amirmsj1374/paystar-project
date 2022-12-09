<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(string $orderId, string $refNum, string $gateway, string $cardNumber) :void
    {
        Transaction::create([
            'order_id' => $orderId,
            'ref_num' => $refNum,
            'gateway' => $gateway,
            'card_number' => $cardNumber
        ]);
    }

    public function getByOrderIdAndRefNum(string $refNum, string $orderId)
    {
        return Transaction::where('ref_num', $refNum)->where('order_id', $orderId)->first();
    }

    public function update(Transaction $traansaction, array $data)
    {
        return $traansaction->update($data);
    }
}
