<?php namespace Spanky\Instagram;

use Spanky\Instagram\Http;
use Spanky\Instagram\Collections\UserCollection;
use Spanky\Instagram\Collections\MediaCollection;
use Spanky\Instagram\Exceptions\AuthenticationException;
use Spanky\Instagram\Entities\AuthorizedUser;
use Spanky\Instagram\Entities\User;
use Spanky\Instagram\Transformers\UserTransformer;

class Instagram {

	/**
	 * Constructor.
	 *
	 * Inject the client and configuration details.
	 * 
	 * @param ClientInterface $client
	 */

	public function __construct(Http $http) 
	{
		$this->http = $http;
	}


	/**
	 * Set the access token to be used in
	 * authorizing requests on the Http
	 * object.
	 * 
	 * @param string $token
	 */

	public function setAccessToken($token) 
	{
		$this->http->setAccessToken($token);
	}


	/**
	 * Retrieve the access token.
	 * 
	 * @param  string $code
	 * @param  array  $config
	 * @return string
	 */

	public function getAccessToken($code, $config) 
	{
		$response = $this->http->request('post', 'https://api.instagram.com/oauth/access_token', array(

			'client_id'		=> $config['client_id'],
			'client_secret'	=> $config['client_secret'],
			'grant_type'	=> 'authorization_code',
			'redirect_uri'	=> $config['redirect_uri'],
			'code'			=> $code

		));

		$token = $response->envelope()->access_token;
		// Grab the token from the return payload

		$this->setAccessToken($token);
		// Set the access token

		return $token;
	}

	/**
	 * User methods
	 */


	/**
	 * Retrieve the user that authorized
	 * the requests.
	 * 
	 * @return Spanky\Instagram\Entities\User
	 */

	public function getAuthorizedUser() 
	{
		$response = $this->http->request('get', 'users/self');
		// Get the details of the authorized user

		$transformer = new UserTransformer();

		return new AuthorizedUser($transformer->transform($response->data()), $this);
	}


	/**
	 * Retrieve the a user by their id.
	 * 
	 * @return Spanky\Instagram\Entities\User
	 */

	public function getUser($user_id) 
	{
		$response = $this->http->request('get', 'users/' . $user_id);

		$transformer = new UserTransformer();

		return new User($transformer->transform($response->data()), $this);
	}


	/**
	 * Relationship methods
	 */


	/**
	 * Get the collection of users following a user
	 * by user id.
	 * 
	 * @param  int 	  $user_id
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function getFollowers($user_id, $options = array()) 
	{
		$response = $this->http->request('get', 'users/'.$user_id.'/followed-by');

		return new UserCollection($response->data(), $response->pagination(), $this);
	}


	/**
	 * Get the collection of users a user is following.
	 * 
	 * @param  int 	  $user_id
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function getFollowing($user_id, $options = array()) 
	{
		$response = $this->http->request('get', 'users/'.$user_id.'/follows');

		return new UserCollection($response->data(), $response->pagination(), $this);
	}


	/**
	 * Get the collection of users that have requested to
	 * follow the authorized user.
	 * 
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function getRequestedBy() 
	{
		$response = $this->http->request('get', 'users/self/requested-by');

		return new UserCollection($response->data(), $response->pagination(), $this);
	}


	/**
	 * Get the relationship data between the authorized
	 * user and another.
	 * 
	 * @param  int $user_id
	 * @return stdClass
	 */

	public function getRelationship($user_id) 
	{
		return $this->http->request('get', 'users/'.$user_id.'/relationship')->data();
	}


	/**
	 * Follow/unfollow/block/unblock/accept/deny a user from
	 * the authorized user's account.
	 * 
	 * @param int $user_id
	 * @param string $action
	 */

	public function setRelationship($user_id, $action) 
	{
		$params = array('action' => $action);
		$response = $this->http->request('post', 'users/'.$user_id.'/relationship', $params);

		return $response->data();
	}


	/**
	 * Media methods
	 */


	/**
	 * Retrieve the media belonging to a user
	 * specified by user id.
	 * 
	 * @param  int 	  $user_id
	 * @param  array  $params
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function getRecentMedia($user_id, $params = array()) 
	{
		$response = $this->hit('get', 'users/' . $user_id . '/media/recent', $params);

		return new MediaCollection(

			$response->data(), 
			$response->pagination()

		);
	}


	/**
	 * Get the media liked by the authorized user.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function getLikedMedia($options = array()) 
	{
		$response = $this->hit('get', 'users/self/media/liked', $options);

		return new MediaCollection(

			$response->data(), 
			$response->pagination(), $this

		);
	}
}