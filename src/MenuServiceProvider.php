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
        ]);

        $this->publishes([
            __DIR__ . '/Models' => app_path('Models'),
        ]);
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/'.env('menu_path')),
        ]);
    }

    public function register()
    {
        $this->app->bind('egideailhami.menu', function () {
            return new Menu();
        });
    }
}
