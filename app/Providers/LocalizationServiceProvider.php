<?php

namespace App\Providers;

use App\Modules\Localization\Interfaces\LocalizationServiceInterface;
use App\Modules\Localization\Services\LocalizationService;
use App\Modules\UserManagement\Services\ReadUserService;
use App\Modules\UserManagement\Services\WriteUserService;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the interface to the implementation
        $this->app->bind(LocalizationServiceInterface::class, function ($app) {
            return new LocalizationService(
                $app->make(WriteUserService::class),
                $app->make(ReadUserService::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
