<?php namespace Spanky\Instagram\Laravel;

use Illuminate\Support\ServiceProvider;
use Config;
use Spanky\Instagram\Factory;
use Illuminate\Foundation\AliasLoader;

class InstagramServiceProvider extends ServiceProvider {

	// this is currently broken as the config is never passed
	// to the authenticator method.
	// consider making these two different di things
	// or putting the config back in the constructor of the factory class.

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
		// Register the package

		$this->app->bind('instagram', function() 
		{
			$config = Config::get('instagram::config');
			return new Factory();
		});
		// Bind the instagram key in the container, with
		// the Spanky\Instagram\Factory class, passing 
		// in the config

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