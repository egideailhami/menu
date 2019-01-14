<?php
namespace GritTekno\Menu;

use Illuminate\Support\ServiceProvider;

/**
 *
 */
class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'grittekno.menu');

        $this->commands('command.grittekno.migration');

        // $this->publishes([
        //     __DIR__ . '/migrations' => database_path('migrations'),
        // ], 'grittekno-migrations');

        // $this->publishes([
        //     __DIR__ . '/seeds' => database_path('seeds'),
        // ], 'grittekno-seeds');

        // $this->publishes([
        //     __DIR__ . '/assets' => public_path('vendor'),
        // ], 'grittekno-assets');
        
        // $this->publishes([
        //     __DIR__ . '/views' => base_path('resources/views/'.env('menu_path')),
        // ], 'grittekno-menu');
    }

    public function register()
    {
        $this->app->bind('grittekno.menu', function () {
            return new Menu();
        });
    }
}
