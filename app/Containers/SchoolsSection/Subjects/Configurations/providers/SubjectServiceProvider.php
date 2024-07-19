<?php

namespace App\Containers\SchoolsSection\Subjects\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\SchoolsSection\Subjects\Subjects;
class SubjectServiceProvider extends ServiceProvider
{
        use RegisterComponentsTraits;
    /**
     * Register services.
     */

    public const CONTAINER_NAME = 'Subjects';

    public const CONTAINER_CLASS = Subjects::class;


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
