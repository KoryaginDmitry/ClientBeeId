<?php

namespace App\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use App\Drivers\Socialite\BeeIdDriver;

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
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('bee_id', function () use ($socialite) {
            $config = config('services.bee_id');

            return $socialite->buildProvider(BeeIdDriver::class, $config);
        });
    }
}
