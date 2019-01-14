<?php
namespace GritTekno\Menu;

use Illuminate\Support\ServiceProvider;

/**
 *
 */
class MenuServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->commands('command.grittekno.migration');

    }

    public function register()
    {
        $this->app->bind('grittekno', function ($app) {
            return new Menu($app);
        });

        $this->app->alias('grittekno', 'GritTekno\Menu');

        $this->app->singleton('command.grittekno.migration', function ($app) {
            return new MigrationCommand();
        });
    }

    public function provides()
    {
        return [
            'command.grittekno.migration'
        ];
    }
}
