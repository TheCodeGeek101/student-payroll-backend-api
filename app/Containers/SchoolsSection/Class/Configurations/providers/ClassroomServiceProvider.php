<?php

namespace App\Containers\SchoolsSection\Class\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\SchoolsSection\Class\Classes;
class ClassroomServiceProvider extends ServiceProvider
{

    use RegisterComponentsTraits;
    /**
     * Register services.
     */
    public const CONTAINER_NAME = 'Class';

    public const CONTAINER_CLASS = Classes::class;
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
