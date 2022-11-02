<?php

namespace App\Providers;

use App\Repositories\Interfaces\RegisterRepositoryInterface;
use App\Repositories\RegisterRepository;
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
        $this->app->bind(RegisterRepositoryInterface::class, RegisterRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
