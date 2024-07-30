<?php

namespace App\Containers\SchoolsSection;

use App\Containers\SchoolsSection\Class\Configurations\providers\ClassroomServiceProvider;
use App\Containers\SchoolsSection\Department\Configurations\providers\DepartmentServiceProvider;
use App\Containers\SchoolsSection\Grades\Configurations\providers\GradesServiceProvider;
use App\Containers\SchoolsSection\Subjects\Configurations\providers\SubjectServiceProvider;
use Illuminate\Support\ServiceProvider;

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
        $this->app->register(DepartmentServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
