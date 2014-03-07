<?php namespace Spanky\Instagram;

use Guzzle\Http\Client;
use Spanky\Instagram\Client\GuzzleClient;
use Spanky\Instagram\Http;
use Spanky\Instagram\Instagram;
use Spanky\Instagram\Authorizor;

class Factory {

	/**
	 * Holds the config details, if set.
	 * 
	 * @var array
	 */

	private $config;


	/**
	 * Set the config details.
	 * 
	 * @param array $config
	 */

	public function setConfig($config) 
	{
		$this->config = $config;
	}


	/**
	 * Create an instance of the Authorizor class.
	 * 
	 * @return Spanky\Instagram\Authorizor
	 */

	public static function authorizor($config = null) 
	{
		return new Authorizor(self::api(), $config ?: $this->config);
	}


	/**
	 * Create an instance of the Api class.
	 * 
	 * @return Spanky\Instagram\Instagram
	 */

	public static function api() 
	{
		$http = new Http(new GuzzleClient(new Client));
		return new Instagram($http);
	}
}