<?php namespace Spanky\Instagram\Client;

use stdClass;

class Response {

	/**
	 * The raw body of the response.
	 * 
	 * @var string
	 */

	private $body;


	/**
	 * The status code of the response.
	 * 
	 * @var int
	 */

	private $status_code;


	/**
	 * Constructor.
	 * 
	 * @param string $body
	 * @param int $status_code
	 */

	public function __construct( $body, $status_code ) 
	{
		$this->body = $body;
		$this->status_code = $status_code;
	}


	/**
	 * Retrieve the raw body.
	 * 
	 * @return string
	 */

	public function getRawBody() 
	{
		return $this->body;
	}

	/**
	 * Retrieve the object representation of 
	 * the full JSON response.
	 * 
	 * @return stdClass
	 */

	public function envelope() 
	{
		return json_decode($this->body);
	}


	/**
	 * Retrieve the meta part of the envelope.
	 * 
	 * @return stdClass
	 */

	public function meta() 
	{
		return $this->envelope()->meta;
	}


	/**
	 * Retrieve the data part of the envelope.
	 * 
	 * @return mixed
	 */

	public function data() 
	{
		return $this->envelope()->data;
	}


	/**
	 * Retrieve the pagination part of the envelope.
	 * 
	 * @return stdClass
	 */

	public function pagination() 
	{
		return isset($this->envelope()->pagination) ? $this->envelope()->pagination : null;
	}


	/**
	 * Determine whether the response is 
	 * valid or not.
	 * 
	 * @return boolean
	 */

	public function isValid() 
	{
		return 

			$this->envelope() instanceof stdClass 

			and 

			! isset($this->envelope()->meta->error_type);
	}
}