<?php

namespace Ertomy\Roles;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // migraciones
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        // registrar el middleware
        $this->app['router']->aliasMiddleware('role', \Ertomy\Roles\Middleware\RoleMiddleware::class);

        // comando añadir rol
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Ertomy\Roles\Console\Commands\AddRole::class,         
            ]);
        }

        // directiva blade
        Blade::if('role', function ($role) {
            return auth()->user()->hasRole($role);
        });
    }

    
}