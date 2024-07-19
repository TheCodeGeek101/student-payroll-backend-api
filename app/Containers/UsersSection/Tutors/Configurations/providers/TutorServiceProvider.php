<?php

namespace App\Containers\UsersSection\Tutors\Configurations\providers;

use App\Containers\UsersSection\Tutors\Tutors;
use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
class TutorServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;
    public const CONTAINER_NAME = 'Tutors';
    /**
     * Register services.
     */
    public const CONTAINER_CLASS = Tutors::class;

    public function register(): void
    {

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
