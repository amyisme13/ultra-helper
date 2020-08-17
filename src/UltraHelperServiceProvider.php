<?php

namespace Amyisme13\UltraHelper;

use Amyisme13\UltraHelper\Console\SyncUsers;
use Illuminate\Support\ServiceProvider;

class UltraHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ultra-helper');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ultra-helper');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ultra-helper.php'),
            ], 'config');

            // Publishing the migrations.
            // $this->publishes([
            //     __DIR__ . '/../database/migrations/' => database_path('migrations'),
            // ], 'migrations');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/ultra-helper'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/ultra-helper'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/ultra-helper'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ultra-helper');

        // Register the main class to use with the facade
        $this->app->singleton('ultra-helper', function () {
            return new UltraHelper;
        });
    }
}
