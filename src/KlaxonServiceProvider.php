<?php

namespace Jacofda\Klaxon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class KlaxonServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'jacofda');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();
        $this->createFolders();
        $this->copyFiles();

        if ($this->app->runningInConsole()) {

            $seeders = [
                __DIR__ . '/../database/seeds/cities.sql' => database_path('seeds/cities.sql'),
                __DIR__ . '/../database/seeds/CitiesSeeder.php' => database_path('seeds/CitiesSeeder.php'),
                __DIR__ . '/../database/seeds/countries.sql' => database_path('seeds/countries.sql'),
                __DIR__ . '/../database/seeds/CountriesSeeder.php' => database_path('seeds/CountriesSeeder.php'),
                __DIR__ . '/../database/seeds/SettingsSeeder.php' => database_path('seeds/SettingsSeeder.php'),
                __DIR__ . '/../database/seeds/ExemptionsSeeder.php' => database_path('seeds/ExemptionsSeeder.php'),
                __DIR__ . '/../database/seeds/StarterSeeder.php' => database_path('seeds/StarterSeeder.php'),
                __DIR__ . '/../database/seeds/PermissionsSeeder.php' => database_path('seeds/PermissionsSeeder.php'),
                __DIR__ . '/../database/seeds/GroupsSeeder.php' => database_path('seeds/GroupsSeeder.php'),
            ];

            $this->publishes($seeders, 'klaxon.migrations');

            // Publishing the translation.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang'),
            ], 'core.trans');
            // Publishing the configs.
            $this->publishes([
              __DIR__.'/../config/klaxon.php' => config_path('klaxon.php'),
              __DIR__.'/../config/invoice.php' => config_path('invoice.php'),
              __DIR__.'/../config/fe.php' => config_path('fe.php'),
              __DIR__.'/../config/flare.php' => config_path('flare.php'),
          ], 'klaxon.config');


        }
    }



    protected function registerRoutes()
    {
        Route::group(['middleware' => ['web', 'auth']], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }




    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        //$this->mergeConfigFrom(__DIR__.'/../config/klaxon.php', 'klaxon');

        // Register the service the package provides.
        $this->app->singleton('klaxon', function ($app) {
            return new Klaxon;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['klaxon'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/klaxon.php' => config_path('klaxon.php'),
        ], 'core.config');

        // Publishing the views.
        // $this->publishes([
        //     __DIR__.'/../resources/views' => base_path('resources/views/vendor/jacofda'),
        // ], 'core.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/jacofda'),
        ], 'core.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/jacofda'),
        ], 'core.views');*/

        // Registering package commands.
        // $this->commands([]);
    }

    private function createFolders() {
        $paths = [
            'public/products',
            'public/products/docs',
            'public/products/original',
            'public/products/full',
            'public/products/display',
            'public/products/thumb'
        ];

        foreach($paths as $path) {
            if(!Storage::exists('app/'.storage_path($path)))
                Storage::makeDirectory($path);
        }
    }

    private function copyFiles()
    {
        if( file_exists(app_path('Http/Middleware/SetLocale.php')) )
        {
            unlink(app_path('Http/Middleware/SetLocale.php'));
        }
        copy(__DIR__.'/Http/Middleware/SetLocale.php', app_path('Http/Middleware/SetLocale.php'));
    }

}
