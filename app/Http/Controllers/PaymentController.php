<?php

namespace App\Http\Controllers;

use App\Facades\TransactionRepositoryFacade;
use App\Http\Requests\PaymentCreateRequest;
use App\Services\PaystarService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function checkout()
    {
        return Inertia::render('Payment/Index', [
            'order_id' => config('order.order_id'),
            'product_name' => config('order.product_name'),
            'product_description' => config('order.product_description'),
            'price' => config('order.price'),
            'gateway' => 'paystar'
        ]);
    }

    public function create(PaymentCreateRequest $request)
    {
        if ($request->gateway == 'paystar') {
            $token = app(PaystarService::class)->createPayment($request->card_number);
        }

        return Inertia::render('Payment/Direction', [
            'token' => $token
        ]);
    }

    public function invoice(Request $request)
    {
        $transaction = TransactionRepositoryFacade::getByOrderIdAndRefNum($request->ref_num, $request->order_id);

        if ($transaction->gateway == 'paystar') {
            $data = app(PaystarService::class)->invoiceData($request, $transaction);
        }

        return Inertia::render('Payment/Invoice', $data);
    }
}
