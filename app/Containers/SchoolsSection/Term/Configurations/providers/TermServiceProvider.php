<?php

namespace App\Containers\SchoolsSection\Term\Configurations\providers;

use Illuminate\Support\ServiceProvider;
use App\Ship\Traits\RegisterComponentsTraits;
use App\Containers\SchoolsSection\Term\Terms;
class TermServiceProvider extends ServiceProvider
{
    use RegisterComponentsTraits;


    public const CONTAINER_NAME = 'Term';

    public const CONTAINER_CLASS = Terms::class;
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
