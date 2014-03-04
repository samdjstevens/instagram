<?php namespace Spanky\Instagram;

use Guzzle\Http\Client;
use Spanky\Instagram\Client\GuzzleClient;
use Spanky\Instagram\Authenticator;
use Spanky\Instagram\Instagram;
use Spanky\Instagram\Http;

class Factory {

	/**
	 * Create an instance of the Authenticator class.
	 * 
	 * @return Spanky\Instagram\Authenticator
	 */

	public static function authenticator($config) 
	{
		return new Authenticator(self::api(), $config);
	}


	/**
	 * Create an instance of the Api class.
	 * 
	 * @return Spanky\Instagram\Api
	 */

	public static function api() 
	{
		$http = new Http(new GuzzleClient(new Client));
		return new Instagram($http);
	}
}