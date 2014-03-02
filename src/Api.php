<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\ClientInterface;
use Spanky\Instagram\Collections\UserCollection;
use Spanky\Instagram\Collections\MediaCollection;
use Exception;
use Spanky\Instagram\Exceptions\AuthenticationException;
use Spanky\Instagram\Exceptions\ApiRequestException;

class Api {

	/**
	 * The access token to be used for 
	 * authorizing requests.
	 * 
	 * @var string
	 */

	private $accessToken;


	/**
	 * The authorized user.
	 * 
	 * @var Spanky\Instagram\Entities\User
	 */

	private $authorizedUser;


	/**
	 * The configurationd details.
	 * 
	 * @var array
	 */

	private $config;


	/**
	 * The base URL of the API, from which
	 * all endpoints are appended.
	 * 
	 * @var string
	 */

	private $baseUrl = 'https://api.instagram.com/v1/';


	/**
	 * Constructor.
	 *
	 * Inject the client and configuration details.
	 * 
	 * @param ClientInterface $client
	 * @param array           $config
	 */

	public function __construct(ClientInterface $client, array $config) 
	{
		$this->client = $client;
		$this->config = $config;
	}


	/**
	 * Set the access token to be used in
	 * authorizing requests.
	 * 
	 * @param string $token
	 */

	public function setAccessToken($token) 
	{
		$this->accessToken = $token;
	}


	/**
	 * Retrieve the user that authorized
	 * the requests.
	 * 
	 * @return Spanky\Instagram\Entities\User
	 */

	public function getAuthorizedUser() 
	{
		return $this->authorizedUser;
	}


	/**
	 * Retrieve a user object by their id.
	 * 
	 * @param  int $user_id
	 * @return Spanky\Instagram\Entities\User
	 */

	public function getUser($user_id) 
	{
		$response = $this->hit('get', 'users/' . $user_id);

		$collection = new UserCollection(

			array($response->data()), 
			$response->pagination()

		);
		// Create a new User collection, with just the one user

		return $collection->first();
		// Return the user
	}


	/**
	 * Retrieve the media belonging to a user
	 * specified by user id.
	 * 
	 * @param  int 	  $user_id
	 * @param  array  $params
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function userMedia($user_id, $params = array()) 
	{
		$response = $this->hit('get', 'users/' . $user_id . '/media/recent', $params);

		return new MediaCollection(

			$response->data(), 
			$response->pagination()

		);
	}














	public function getAccessToken($code) 
	{
		try 
		{
			$response = $this->hit('post', 'https://api.instagram.com/oauth/access_token', array(

				'client_id'		=> $this->config['client_id'],
				'client_secret'	=> $this->config['client_secret'],
				'grant_type'	=> 'authorization_code',
				'redirect_uri'	=> $this->config['redirect_uri'],
				'code'			=> $code

			));
			// Get the data

			$token = $response->data()->access_token;
			$this->setAccessToken($token);
			// Grab the token and set it
			// 

			$this->authorizedUser = $this->getUser((int) $response->data()->user->id);

			return $token;
			// Return the token
		}
		catch( Exception $e ) 
		{
			throw new AuthenticationException("Could not grab the access token.");
			// The request failed, throw an exception
		}
	}









	
	// public function isAuthorized() 
	// {
	// 	// try to get the authorized user?
	// 	// but thats not been set if already
	// 	// authorized
	// 	// how can we check if authorized?
	// }






	public function hit($method, $endpoint, $params = array()) 
	{
		$url = substr($endpoint, 0, 4) == "http" ? $endpoint : $this->baseUrl . $endpoint;

		if ($this->accessToken) 
		{
			$params['access_token'] = $this->accessToken;
		}
		else if ($this->clientId)
		{
			$params['client_id'] = $this->clientId;
		}
		// Add the auth in

		$response = $this->client->{$method}($url, $params);

		return $response;

		// check for isValid here
	}










}