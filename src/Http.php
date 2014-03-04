<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\ClientInterface;

class Http {

	/**
	 * The base URL of the API, from which
	 * all endpoints are appended.
	 * 
	 * @var string
	 */

	private $baseUrl = 'https://api.instagram.com/v1/';


	/**
	 * The access token to send with requests.
	 * 
	 * @var string
	 */
	
	private $accessToken;


	/**
	 * Constructor.
	 *
	 * Inject the client and configuration details.
	 * 
	 * @param ClientInterface $client
	 * @param array           $config
	 */

	public function __construct(ClientInterface $client) 
	{
		$this->client = $client;
	}


	/**
	 * Set the access token.
	 * 
	 * @param string $token
	 */

	public function setAccessToken($token) 
	{
		$this->accessToken = $token;
	}


	/**
	 * Make a request to a URL, using the client.
	 * 
	 * @param  string $method
	 * @param  string $endpoint
	 * @param  array  $params
	 * @return Spanky\Instagram\Client\Response
	 */

	public function request($method, $endpoint, $params = array()) 
	{
		$url = substr($endpoint, 0, 4) == "http" ? $endpoint : $this->baseUrl . $endpoint;
		// Append the endpoint with the base URL, unless the endpoint 
		// is already a URL.

		if ($this->accessToken) 
		{
			$params['access_token'] = $this->accessToken;
		}
		// Add the access token
		
		return $this->client->{$method}($url, $params);
	}
}