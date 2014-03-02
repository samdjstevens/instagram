<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\GuzzleClient;
use Spanky\Instagram\Authenticator;
use Spanky\Instagram\Api;

class Factory {

	static $config;

	public function __construct($config = array()) 
	{
		self::$config = $config;
	}

	public static function authenticator() 
	{
		$guzzle = new \Guzzle\Http\Client;
		$client = new GuzzleClient($guzzle);
		// Create the GuzzleClient object

		return new Authenticator($client, self::$config);
	}

	public static function api() 
	{
		$guzzle = new \Guzzle\Http\Client;
		$client = new GuzzleClient($guzzle);
		// Create the GuzzleClient object

		return new Api($client);
	}
}