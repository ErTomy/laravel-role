<?php

namespace Ertomy\Roles;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        Blade::if('role', function ($role) {
            return auth()->user()->hasRole($role);
        });




    }

    
}