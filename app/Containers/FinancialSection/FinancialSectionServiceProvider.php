<?php

namespace App\Containers\FinancialSection;

use Illuminate\Support\ServiceProvider;
use App\Containers\FinancialSection\Payments\Configurations\providers\PaymentServiceProvider;
class FinancialSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(PaymentServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
