<?php

namespace App\Containers\SchoolsSection;

use Illuminate\Support\ServiceProvider;
use App\Containers\SchoolsSection\Grades\Configurations\providers\GradesServiceProvider;
use App\Containers\SchoolsSection\Subjects\Configurations\providers\SubjectServiceProvider;
use App\Containers\SchoolsSection\Class\Configurations\providers\ClassroomServiceProvider;
class SchoolsSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(GradesServiceProvider::class);
        $this->app->register(SubjectServiceProvider::class);
        $this->app->register(ClassroomServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
