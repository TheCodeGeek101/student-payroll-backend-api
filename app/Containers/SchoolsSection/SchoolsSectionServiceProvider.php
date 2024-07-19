<?php

namespace App\Containers\SchoolsSection;

use Illuminate\Support\ServiceProvider;
use App\Containers\SchoolsSection\Grades\Configurations\providers\GradesServiceProvider;
use App\Containers\SchoolsSection\Subjects\Configurations\providers\SubjectServiceProvider;
class SchoolsSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(GradesServiceProvider::class);
        $this->app->register(SubjectServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
