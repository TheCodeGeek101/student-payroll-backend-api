<?php

namespace App\Ship\Traits;
use ReflectionClass;
trait RegisterComponentsTraits
{
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(dirname((new ReflectionClass($this))->getFileName()) . '/../../Data/Migrations');
    }

    public function registerConfig()
    {
        $this->publishes([
            dirname((new ReflectionClass($this))->getFileName()) . '/../config.php' => config_path(
                strtolower(self::CONTAINER_NAME) . '.php'
            ),
        ]);
    }

    public function registerFacade()
    {
        $this->app->bind(strtolower(self::CONTAINER_NAME), function ($app) {
            return $app->make(self::CONTAINER_CLASS);
        });
    }

//    public function registerCommands()
//    {
//        $commandRegistrar =  self::COMMAND_REGISTRAR;
//        $this->commands((new $commandRegistrar())->handle());
//    }

}
