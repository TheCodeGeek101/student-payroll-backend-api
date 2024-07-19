<?php

namespace App\Containers\SchoolsSection\Grades\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\SchoolsSection\Grades\Grades;

class GradesServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;
    /**
     * Register services.
     */

    public const CONTAINER_NAME = 'Grades';

    public const CONTAINER_CLASS = Grades::class;

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
