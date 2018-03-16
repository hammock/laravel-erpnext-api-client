<?php

namespace Hammock\LaravelERPNext;

use Illuminate\Support\ServiceProvider;
use Hammock\LaravelERPNext\Configuration\ConfigurationInterface;
use Hammock\LaravelERPNext\Configuration\LaravelConfiguration;

class ERPNextServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/erpnext.php', 'erpnext');
        $this->publishes([
            __DIR__ . '/../config/erpnext.php' => config_path('erpnext.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConfigurationInterface::class, function () {
            return new LaravelConfiguration();
        });
        $this->app->bind('Hammock\LaravelERPNext\ERPNextClient', function () {
            return $this->app->make(ERPNextClient::class);
        });
        $this->app->alias('Hammock\LaravelERPNext\ERPNextClient', 'erpnext');
    }
}
