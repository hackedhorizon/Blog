<?php

namespace App\Providers;

use App\Modules\Post\Interfaces\WritePostRepositoryInterface;
use App\Modules\Post\Interfaces\WritePostServiceInterface;
use App\Modules\Post\Repositories\WritePostRepository;
use App\Modules\Post\Services\WritePostService;
use Illuminate\Support\ServiceProvider;

class WritePostServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the interface to the service
        $this->app->bind(WritePostServiceInterface::class, WritePostService::class);

        // Bind the repository interface to the repository
        $this->app->bind(WritePostRepositoryInterface::class, WritePostRepository::class);
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
