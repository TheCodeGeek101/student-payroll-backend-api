<?php

namespace App\Containers\UsersSection;

use Illuminate\Support\ServiceProvider;
use App\Containers\UsersSection\Students\Configurations\providers\StudentServiceProvider;
use App\Containers\UsersSection\Tutors\Configurations\providers\TutorServiceProvider;
use App\Containers\UsersSection\Guardians\Configurations\providers\GuardianServiceProvider;
class UsersSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(StudentServiceProvider::class);
        $this->app->register(TutorServiceProvider::class);
        $this->app->register(GuardianServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
