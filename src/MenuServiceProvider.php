<?php
namespace Egideailhami\Menu;

use Illuminate\Support\ServiceProvider;

/**
 *
 */
class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'egideailhami.menu');

        $this->publishes([
            __DIR__ . '/migrations' => database_path('migrations'),
        ], 'grittekno-migrations');

        $this->publishes([
            __DIR__ . '/seeds' => database_path('seeds'),
        ], 'grittekno-seeds');

        $this->publishes([
            __DIR__ . '/fontawesome-iconpicker' => public_path('vendor/fontawesome-iconpicker'),
            __DIR__ . '/js' => public_path('vendor/js'),
        ], 'grittekno-assets');
        
        // $this->publishes([
        //     __DIR__ . '/views' => base_path('resources/views/'.env('menu_path')),
        // ], 'grittekno-menu');
    }

    public function register()
    {
        $this->app->bind('egideailhami.menu', function () {
            return new Menu();
        });
    }
}
