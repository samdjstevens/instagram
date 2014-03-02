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
			$this->formScopeString($scopes)

		);
	}


	/**
	 * Helper function to form the scope field
	 * used when forming the authorize URL.
	 * 
	 * @param  array  $scopes
	 * @return string
	 */

	private function formScopeString(array $scopes) 
	{
		$allowed_scopes = array('basic', 'comments', 'relationships', 'likes');
		// The allowed/defined scopes

		$scopes = array_filter($scopes, function($item) use ($allowed_scopes) 
		{
			return in_array($item, $allowed_scopes);

		});
		// Filter the array entered to those only in the
		// allowed array

		return implode('+', $scopes);
		// Return the scopes as a string, joined by "+"
	}


	/**
	 * Retrieve an access token from a code.
	 * 
	 * @param  string $code
	 * @return string
	 */

	public function getAccessToken($code) 
	{
		return $this->api->getAccessToken($code);
	}


	/**
	 * Get the user that has just authorized 
	 * the application.
	 * 
	 * @return Spanky\Instagram\Entities\User
	 */

	public function getAuthorizedUser() 
	{
		return $this->api->getAuthorizedUser();
	}
}