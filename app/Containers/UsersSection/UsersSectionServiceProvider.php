<?php

namespace App\Containers\UsersSection;


use App\Containers\UsersSection\Guardians\Configurations\providers\GuardianServiceProvider;
use App\Containers\UsersSection\Students\Configurations\providers\StudentServiceProvider;
use App\Containers\UsersSection\Tutors\Configurations\providers\TutorServiceProvider;
use Illuminate\Support\ServiceProvider;
use App\Containers\UsersSection\Admin\Configurations\providers\AdminServiceProvider;
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
        $this->app->register(AdminServiceProvider::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
