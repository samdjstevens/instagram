<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\ClientInterface;
use Spanky\Instagram\Collections\UserCollection;
use Spanky\Instagram\Collections\MediaCollection;

class Api {


	private $accessToken;

	private $baseUrl = 'https://api.instagram.com/v1/';

	public function __construct(ClientInterface $client) 
	{
		$this->client = $client;
	}


	public function setAccessToken($token) 
	{
		$this->accessToken = $token;
		return $this;
	}


	public function getUser($user_id) 
	{
		$details = $this->get('users/'.$user_id);

		//var_dump($me);

		$collection = new UserCollection(array($details->data));

		return $collection->first();
	}




	public function media($user_id) 
	{
		$data = $this->get('users/'.$user_id.'/media/recent');
		$media = $data->data;

		return new MediaCollection($media);
	}














	private function get($endpoint, $data=array()) 
	{
		$data = array('access_token' => $this->accessToken) + $data;

		return $this->client->get($this->baseUrl . $endpoint, $data);
	}

	public function post($endpoint, $data=array()) 
	{
		$data = array('access_token' => $this->accessToken) + $data;

		return $this->client->post($this->baseUrl . $endpoint, $data);
	}







}