<?php

namespace App\Containers\FinancialSection\Payments\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\FinancialSection\Payments\Payments;
class PaymentServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;
    /**
     * Register services.
     */
    public const CONTAINER_NAME ='Payments';

    public const CONTAINER_CLASS = Payments::class;

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerConfig();
    }
}
