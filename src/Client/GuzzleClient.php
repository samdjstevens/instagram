<?php namespace Spanky\Instagram\Client;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\QueryString;
use Spanky\Instagram\Exceptions\ApiRequestException;

class GuzzleClient implements ClientInterface {

	/**
	 * The Guzzle client object.
	 * 
	 * @var Guzzle\Http\Client
	 */

	private $guzzle;


	/**
	 * Inject the Guzzle Client into the class 
	 * and configure.
	 * 
	 * @param Guzzle\Http\Client $guzzle
	 */

	public function __construct(Client $guzzle) 
	{
		$this->guzzle = $guzzle;
		$this->guzzle->setDefaultOption('allow_redirects', false);
	}


	/**
	 * Perform a GET request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function get($url, $data = array()) 
	{
		$request = $this->guzzle->get($url);

		$query = $request->getQuery();
		foreach($data as $key => $val) 
		{
			$query->set($key, $val);
		}
		// Build the query string

		return $this->send($request);
	}


	/**
	 * Perform a POST request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function post($url, $data = array()) 
	{
		$request = $this->guzzle->post($url, array(), $data);
		return $this->send($request);
	}


	/**
	 * Perform a PUT request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function put($url, $data = array()) 
	{
		$query = (string) new QueryString($data);
		// Generate a query string

		$request = $this->guzzle->put($url)->setBody($query);
		// Create a PUT request, setting the body to the
		// query string.

		return $this->send($request);
	}


	/**
	 * Perform a DELETE request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function delete($url, $data = array()) 
	{
		$request = $this->guzzle->delete($url);

		$query = $request->getQuery();
		foreach($data as $key => $val) 
		{
			$query->set($key, $val);
		}
		// Build the query string

		return $this->send($request);
	}


	/**
	 * Fire off a request and return a Response
	 * object representing the result.
	 * 
	 * @param  Guzzle\Http\Message\Request $request
	 * @return Spanky\Instagram\Client\Response
	 */

	public function send($request) 
	{
		try 
		{
			$response = $request->send();
			// Fire off the request

			return new Response((string) $response->getBody(), $response->getStatusCode());
			// Return a new Response with the response body and 
			// status code
		}
		catch (ClientErrorResponseException $e ) 
		{
			throw new ApiRequestException("Bad request.");
		}
	}
}