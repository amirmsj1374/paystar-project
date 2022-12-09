<?php

namespace App\Services;

use App\Facades\TransactionRepositoryFacade;
use App\Interfaces\PaymentInterface;
use App\Jobs\VerifyPaidTransactionJob;
use App\Models\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PaystarService implements PaymentInterface
{

    public function createPayment(string $cardNumber)
    {

        $appDomain = config('app.domain');
        // $callbackUrl = config('app.webhook_callback');

        $orderId = config('order.order_id');

        $price = config('order.price');

        $string = $price . "#" . $orderId . '#' . $appDomain .'/invoice';

        $sign = app(HashHmacService::class)->createSign('SHA512', $string, config('paystar.encryption_key'));

        $client = $this->setClientHeader();

        try {
            $response = $client->request(
                'post',
                'https://core.paystar.ir/api/pardakht/create',
                [
                    'form_params' => [
                        'amount' => $price,
                        'order_id' => $orderId,
                        'callback' => $appDomain . '/invoice',
                        'sign' => $sign,
                        'callback_method' => 1
                    ]
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);

            TransactionRepositoryFacade::create(
                $result['data']['order_id'],
                $result['data']['ref_num'],
                'paystar',
                $cardNumber
            );

            return $result['data']['token'];

        } catch (RequestException $e) {

            // Catch all 4XX errors

            // To catch exactly error 400 use
            if ($e->hasResponse()){

                info([
                    'status' => $e->getResponse()->getStatusCode(),
                    'error' => json_decode($e->getResponse()->getBody()->getContents(), true),
                ]);

                if ($e->getResponse()->getStatusCode() == '400') {
                    return "Got response 400";
                }
            }

            // You can check for whatever error status code you need

        } catch (\Exception $e) {

            // There was another exception.

        }
    }

    public function invoiceData(Request $request, Transaction $transaction)
    {
        if ($request->status == '1') {
            TransactionRepositoryFacade::update($transaction, [
                'status' => 'success',
                "tracking_code" => $request->tracking_code,
                "transaction_id" => $request->transaction_id
            ]);
        }

        if ($request->status == '1' && $this->checkCardNumber($request->card_number, $transaction->card_number)) {
            VerifyPaidTransactionJob::dispatch(
                $request->ref_num,
                $request->card_number,
                $request->tracking_code
            )->delay(now()->addSeconds(10));
        }

        return [
            'order_id' => $request->order_id,
            'tracking_code' => $request->status == '1' ? $request->tracking_code : '',
            'product_name' => config('order.product_name'),
            'product_description' => config('order.product_description'),
            'price' => config('order.price'),
            'message' => $this->getInvoiceMessage($request, $transaction),
        ];
    }

    public function verify(string $refNum, string $cardNumber, string $trackingCode)
    {

        $price = config('order.price');

        $string = $price . "#" . $refNum . '#' . $cardNumber . '#' . $trackingCode;

        $sign = app(HashHmacService::class)->createSign('SHA512', $string, config('paystar.encryption_key'));

        $client = $this->setClientHeader();

        try {
            $response = $client->request(
                'post',
                'https://core.paystar.ir/api/pardakht/verify',
                [
                    'form_params' => [
                        'amount' => $price,
                        'ref_num' => $refNum,
                        'sign' => $sign,
                    ]
                ]
            );

            $result = json_decode($response->getBody()->getContents(), true);

            info([
                'verify paystar' => $result
            ]);

        } catch (RequestException $e) {

            if ($e->hasResponse()){

                info([
                    'ref_num' => $refNum,
                    'status' => $e->getResponse()->getStatusCode(),
                    'error' => json_decode($e->getResponse()->getBody()->getContents(), true),
                ]);

                if ($e->getResponse()->getStatusCode() == '400') {
                    return "Got response 400";
                }
            }

            // You can check for whatever error status code you need

        } catch (\Exception $e) {

            // There was another exception.

        }
    }

    protected function setClientHeader() :Client
    {
        return new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('paystar.gateway_id')
            ],
        ]);
    }

    protected function getInvoiceMessage(Request $request, Transaction $transaction) :string
    {
        return $request->status != '1' ? 'تراکنش ناموفق' : (
            $this->checkCardNumber($request->card_number, $transaction->card_number) ?
             'تراکنش با موفقیت انجام شد.' :
            'تراکنش ناموفق، شماره کارت پرداختی با شماره کارت ثبت شده همخوانی ندارد.'
        );
    }

    protected function checkCardNumber(string $paidCardNumber, string $cardNumber)
    {
        return substr($paidCardNumber, -4) == substr($cardNumber, -4);
    }
}
