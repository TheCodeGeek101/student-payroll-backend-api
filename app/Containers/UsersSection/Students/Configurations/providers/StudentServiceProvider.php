<?php

namespace App\Containers\UsersSection\Students\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\UsersSection\Students\Students;
class StudentServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;

    public const CONTAINER_NAME = 'Students';
    /**
     * Register services.
     */
    public const CONTAINER_CLASS = Students::class;

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
