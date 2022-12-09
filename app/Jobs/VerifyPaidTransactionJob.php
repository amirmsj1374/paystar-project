<?php

namespace App\Jobs;

use App\Services\PaystarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyPaidTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $refNum;
    protected $cardNumber;
    protected $trackingCode;

    public function __construct(string $refNum, string $cardNumber, string $trackingCode)
    {
        $this->refNum = $refNum;
        $this->cardNumber = $cardNumber;
        $this->trackingCode = $trackingCode;
    }

    public function handle()
    {
        app(PaystarService::class)->verify($this->refNum, $this->cardNumber, $this->trackingCode);
    }
}
