<?php namespace Spanky\Instagram;

use Spanky\Instagram\Api;

class Authenticator {

	/**
	 * The Api object.
	 * 
	 * @var Spanky\Instagram\Api
	 */

	private $api;


	/**
	 * The configuration details.
	 * 
	 * @var array
	 */

	private $config;


	/**
	 * The allowed/defined request scopes.
	 * 
	 * @var array
	 */

	private $allowedScopes = array('basic', 'comments', 'relationships', 'likes');


	/**
	 * Inject the Api into the class, along with
	 * the configuration details.
	 * 
	 * @param Api	$api
	 * @param array	$config
	 */

	public function __construct(Api $api, $config = array()) 
	{
		$this->api = $api;
		$this->config = $config;
	}


	/**
	 * Returns the URL to redirect the user to 
	 * so that they may authenticate.
	 * 
	 * @return string
	 */

	public function getAuthorizeUrl( $scopes = array('basic') ) 
	{
		return sprintf(

			'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
			$this->config['client_id'],
			$this->config['redirect_uri'],
			$this->createScopeString($scopes)

		);
	}


	/**
	 * Helper function to form the scope field
	 * used when forming the authorize URL.
	 * 
	 * @param  array  $scopes
	 * @return string
	 */

	private function createScopeString(array $scopes) 
	{
		return implode('+', array_intersect($scopes, $this->allowedScopes));
		// Filter the array entered to those only in the
		// allowed array, and join up the strings with a "+"
	}


	/**
	 * Retrieve an access token from a code.
	 * 
	 * @param  string $code
	 * @return string
	 */

	public function getAccessToken($code) 
	{
		return $this->api->getAccessToken($code, $this->config);
	}
}