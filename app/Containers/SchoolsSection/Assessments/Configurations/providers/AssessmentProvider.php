<?php

namespace App\Containers\SchoolsSection\Assessments\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Containers\SchoolsSection\Assessments\Assessments;
use App\Ship\Traits\RegisterComponentsTraits;
class AssessmentProvider extends ServiceProvider
{
    use RegisterComponentsTraits;

    public const CONTAINER_NAME = 'Assessments';
    public const CONTAINER_CLASS = Assessments::class;
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
