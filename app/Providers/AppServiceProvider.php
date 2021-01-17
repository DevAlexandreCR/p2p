<?php

namespace App\Providers;

use App\Decorators\RoleDecorator;
use App\Interfaces\RoleInterface;
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
    }
}
