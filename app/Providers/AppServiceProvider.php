<?php

namespace App\Providers;

use App\Decorators\PermissionsDecorator;
use App\Decorators\RoleDecorator;
use App\Decorators\UserDecorator;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RoleInterface::class, RoleDecorator::class);
        $this->app->bind(PermissionInterface::class, PermissionsDecorator::class);
        $this->app->bind(UserInterface::class, UserDecorator::class);
    }
}
