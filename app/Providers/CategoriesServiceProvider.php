<?php

namespace App\Providers;

use App\Modules\Categories\Interfaces\ReadCategoryRepositoryInterface;
use App\Modules\Categories\Interfaces\ReadCategoryServiceInterface;
use App\Modules\Categories\Repositories\ReadCategoryRepository;
use App\Modules\Categories\Services\ReadCategoryService;
use Illuminate\Support\ServiceProvider;

class CategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Bind the interfaces to their implementations
        $this->app->bind(ReadCategoryServiceInterface::class, ReadCategoryService::class);
        $this->app->bind(ReadCategoryRepositoryInterface::class, ReadCategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
