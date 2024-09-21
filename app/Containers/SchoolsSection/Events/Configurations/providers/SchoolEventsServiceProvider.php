<?php

namespace App\Containers\SchoolsSection\Events\Configurations\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\SchoolsSection\Events\Events;

class SchoolEventsServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;

    public const  CONTAINER_NAME = 'Events';
    public const CONTAINER_CLASS = Events::class;
    /**
     * Register services.
     */
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
