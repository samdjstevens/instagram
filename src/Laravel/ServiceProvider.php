<?php namespace Spanky\Instagram\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Config;
use Spanky\Instagram\Factory;
use Illuminate\Foundation\AliasLoader;

class ServiceProvider extends BaseServiceProvider {



	public function register() 
	{
		$this->app->bind('instagram', function() 
		{
			$config = Config::get('instagram');
			return new Factory($config);
		});
	}


	public function boot() 
	{
		$this->package('spanky/instagram');

		AliasLoader::getInstance()->alias(

			'Instagram',
			'Spanky\Instagram\Laravel\Facades\Instagram'

		);
	}


	public function provides()
	{
		return array('instagram');
	}
}