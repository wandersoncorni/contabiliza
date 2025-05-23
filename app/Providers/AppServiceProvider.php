<?php

namespace App\Providers;

use App\AccessControl\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

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
        User::observe(\App\Application\Observers\User::class);

        $this->loadViewsFrom(base_path('app/access-control/resources/views'), 'access-control');
        $this->loadViewsFrom(base_path('app/application/resources/views'), 'application');

        $modules = glob(app_path() . '/*', GLOB_ONLYDIR);
        foreach ($modules as $module) {
            if (is_dir("$module/Database/Migrations")) {
                $this->loadMigrationsFrom("$module/Database/Migrations");
            }
        }
    }
}
