<?php

namespace App\Http\Middleware;

use App\Facades\TransactionRepositoryFacade;
use Closure;
use Illuminate\Http\Request;

class CheckRefNumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->filled('ref_num') && !$request->filled('order_id')) {
            $this->createLog($request);
            $this->preventMessage();
        }

        $transaction = TransactionRepositoryFacade::getByOrderIdAndRefNum($request->ref_num, $request->order_id);

        if ($transaction) {

            return $next($request);
        }

        $this->createLog($request);
        $this->preventMessage();
    }

    protected function preventMessage()
    {
        return abort(401 , 'داده های ارسال شده معتبر نمی باشند');
    }

    protected function createLog(Request $request) :void
    {
        info([
            'ref_num in request' => $request->ref_num,
            'ordr_id' => $request->order_id,
            'card_number' => $request->card_number,
        ]);
    }
}
