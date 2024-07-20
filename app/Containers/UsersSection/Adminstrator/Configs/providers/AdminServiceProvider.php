<?php

namespace App\Containers\UsersSection\Adminstrator\Configs\providers;

use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Ship\Traits\RegisterComponentsTraits;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;
    /**
     * Register services.
     */

    public const CONTAINER_NAME = 'Adminstator';

    public const CONTAINER_CLASS = Admin::class;

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerMigrations();
    }
}
