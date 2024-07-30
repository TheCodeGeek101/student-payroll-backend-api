<?php

namespace App\Containers\SchoolsSection\Department\Configurations\providers;

use App\Containers\SchoolsSection\Department\Departments;
use App\Ship\Traits\RegisterComponentsTraits;
use Illuminate\Support\ServiceProvider;

class DepartmentServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;
    /**
     * Register services.
     */
    public const CONTAINER_NAME = 'Department';

    public const CONTAINER_CLASS = Departments::class;
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
