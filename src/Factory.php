<?php namespace Spanky\Instagram;

use Guzzle\Http\Client;
use Spanky\Instagram\Client\GuzzleClient;
use Spanky\Instagram\Authenticator;
use Spanky\Instagram\Api;

class Factory {

	/**
	 * The configuration details.
	 * 
	 * @var array
	 */

	static $config;


	/**
	 * Constructor.
	 * 
	 * @param array $config
	 */

	public function __construct($config = array()) 
	{
		self::$config = $config;
	}


	/**
	 * Create an instance of the Authenticator class.
	 * 
	 * @return Spanky\Instagram\Authenticator
	 */

	public static function authenticator() 
	{
		return new Authenticator(self::api(), self::$config);
	}


	/**
	 * Create an instance of the Api class.
	 * 
	 * @return Spanky\Instagram\Api
	 */

	public static function api() 
	{
		return new Api(new GuzzleClient(new Client), self::$config);
	}
}