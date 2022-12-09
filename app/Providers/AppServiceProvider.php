<?php

namespace App\Providers;

use App\Facades\TransactionRepositoryFacade;
use App\Interfaces\PaymentInterface;
use App\Interfaces\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Services\HashHmacService;
use App\Services\PaystarService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PaymentInterface::class,
            PaystarService::class,
            TransactionRepositoryInterface::class,
            TransactionRepository::class,
            HashHmacService::class
        );

        TransactionRepositoryFacade::proxy(TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
