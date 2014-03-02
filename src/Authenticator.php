<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\ClientInterface;
use Exception;
use Spanky\Instagram\Exceptions\AuthenticationException;

class Authenticator {

	/**	
	 * The Client that makes all our requests.
	 * 
	 * @var Spanky\Instagram\Client\ClientInterface
	 */

	private $client;


	/**
	 * The configuration details.
	 * 
	 * @var array
	 */

	private $config;


	/**
	 * The user id of the authorized user.
	 * Set once an access token has been retrieved.
	 * 
	 * @var int
	 */

	private $user_id;


	/**
	 * Inject the Client into the class, along with
	 * the configuration details.
	 * 
	 * @param ClientInterface	$client
	 * @param array				$config
	 */

	public function __construct(ClientInterface $client, $config = array()) 
	{
		$this->client = $client;
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
		try 
		{
			$data = $this->client->post('https://api.instagram.com/oauth/access_token', array(

				'client_id'		=> $this->config['client_id'],
				'client_secret'	=> $this->config['client_secret'],
				'grant_type'	=> 'authorization_code',
				'redirect_uri'	=> $this->config['redirect_uri'],
				'code'			=> $code

			));
			// Get the data

			$token = $data->access_token;
			// Grab the token

			$this->user_id = (int) $data->user->id;
			// Grab and cast the user id

			return $token;
			// Return the token
		}
		catch( Exception $e ) 
		{
			throw new AuthenticationException("Could not grab the access token.");
			// The request failed, throw an exception
		}
	}


	/**
	 * Get the id of the user that has just authorized 
	 * the application.
	 * 
	 * @return int
	 */

	public function getAuthorizedUserId() 
	{
		return $this->user_id;
	}
}