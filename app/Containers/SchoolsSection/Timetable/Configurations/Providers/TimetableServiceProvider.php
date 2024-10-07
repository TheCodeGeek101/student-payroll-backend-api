<?php

namespace App\Containers\SchoolsSection\Timetable\Configurations\Providers;

use App\Containers\SchoolsSection\Timetable\Timetables;
use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;

class TimetableServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;

    public const CONTAINER_NAME = 'Timetable';

    public const CONTAINER_CLASS = Timetables::class;
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
