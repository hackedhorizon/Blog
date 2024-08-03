<?php

namespace App\Providers;

use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Services\ReadPostService;
use Illuminate\Support\ServiceProvider;

class ReadPostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the interface to the implementation
        $this->app->bind(ReadPostServiceInterface::class, ReadPostService::class);
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
