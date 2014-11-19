<?php namespace Chew\Laravel\Azure;

use Illuminate\Support\ServiceProvider;
use WindowsAzure\Common\ServicesBuilder;

class AzureServiceProvider extends ServiceProvider {

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
		$this->package('unm/laravel4-azure', 'azure', __DIR__. '/../../..');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        $this->app->bind('azure', function($app) {
            return new Azure(ServicesBuilder::getInstance(), $app['config']->get('azure::config'));
        });

        # Shortcut so developers don't need to add an Alias in app/config/app.php
//        $this->app->booting(function()
//        {
//            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//            $loader->alias('azure', 'Chew\Laravel\Azure\AzureFacade');
//        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('azure');
	}

}