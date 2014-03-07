<?php namespace Spanky\Instagram\Laravel;

use Illuminate\Support\ServiceProvider;
use Config;
use Spanky\Instagram\Factory;
use Illuminate\Foundation\AliasLoader;

class InstagramServiceProvider extends ServiceProvider {

	/**
	 * Register the package.
	 * 
	 * @return void
	 */

	public function register() 
	{
		// Do nothing.
	}

	/**
	 * Boot the package.
	 *
	 * Bind the key in the container now, so we
	 * can properly access the configuration files.
	 * 
	 * @return void
	 */

	public function boot() 
	{
		$this->package('spanky/instagram', null, realpath(dirname(__FILE__).'/../'));

		$this->app->bind('instagram', function() 
		{
			$factory = new Factory();
			$factory->setConfig(Config::get('instagram::config'));
			return $factory;
		});

		AliasLoader::getInstance()->alias(

			'Instagram',
			'Spanky\Instagram\Laravel\Facades\Instagram'

		);
		// Define the "Instagram" alis for the facade
	}


	/**
	 * Return an array of container keys this service 
	 * provider creates.
	 * 
	 * @return array
	 */

	public function provides()
	{
		return array('instagram');
	}
}