<?php namespace Spanky\Instagram\Client;

interface ClientInterface {

	/**
	 * Perform a GET request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function get($url, $data = array());


	/**
	 * Perform a POST request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function post($url, $data = array());


	/**
	 * Perform a PUT request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function put($url, $data = array());


	/**
	 * Perform a DELETE request.
	 * 
	 * @param  string $url  The URL to hit.
	 * @param  array  $data Any fields to pass along (optional).
	 */

	public function delete($url, $data = array());
}