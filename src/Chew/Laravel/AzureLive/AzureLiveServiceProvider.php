<?php

namespace Chew\Laravel;

use Illuminate\Support\ServiceProvider;

use Chew\Laravel\AzureLive;
// use WindowsAzure\Common\ServicesBuilder;

class AzureLiveServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Register 'azurelive' instance container to our AzureLive object
        $this->app['azurelive'] = $this->app->share(function($app)
        {
            return new Fideloper\Example\AzureLive;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('AzureLive', 'Chew\Laravel\Facades\AzureLive');
        });
    }

}