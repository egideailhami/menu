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
    }

    public function register()
    {
        $this->app->bind('egideailhami.menu', function () {
            return new Menu();
        });
    }
}
