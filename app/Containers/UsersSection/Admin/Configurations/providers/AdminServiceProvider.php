<?php

namespace App\Containers\UsersSection\Admin\Configurations\providers;

use App\Containers\UsersSection\Admin\Admins;
use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
class AdminServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;


    public const CONTAINER_NAME = 'Admin';

    public const CONTAINER_CLASS = Admins::class;
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
