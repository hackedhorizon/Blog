<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(
            ! app()->isProduction()
        );
        $this->registerGates();
    }

    /**
     * Registers the defined gates.
     */
    protected function registerGates(): void
    {
        /**
         * Attempts to register the defined gates.
         *
         * @throws \Exception If the database is not found or not yet migrated.
         */
        try {
            foreach (Permission::pluck('name') as $permission) {
                /**
                 * Defines a new gate with the specified name and callback.
                 *
                 * @param  string  $permission  The name of the gate.
                 * @param  callable  $callback  The callback function to determine whether the user has access.
                 */
                Gate::define($permission, function ($user) use ($permission) {
                    /**
                     * Checks if the user has the specified permission.
                     *
                     * @param  string  $permission  The name of the permission.
                     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Auth\Authenticatable|null  $user  The user to check.
                     * @return bool Whether the user has the specified permission.
                     */
                    return $user->hasPermission($permission);
                });
            }
        } catch (\Exception $e) {
            /**
             * Logs a message indicating that the database is not found or not yet migrated.
             *
             * @param  string  $message  The message to log.
             * @param  int  $level  The log level.
             */
            info('registerPermissions(): Database not found or not yet migrated. Ignoring user permissions while booting app.');
        }
    }
}
