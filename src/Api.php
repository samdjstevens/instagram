<?php namespace Spanky\Instagram;

use Spanky\Instagram\Client\ClientInterface;
use Spanky\Instagram\Entities\User;
use Spanky\Instagram\Entities\Photo;
use Spanky\Instagram\Entities\Video;

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

		$user = array(

			'id'	=> $details->data->id,
			'username'	=> $details->data->username,
			'profile_picture'	=> $details->data->profile_picture,
			'full_name'			=> $details->data->full_name,
			'bio'			=> $details->data->bio,
			'website'			=> $details->data->website,

		);

		return new User($user);
	}



	// public function feed() 
	// {
	// 	return $this->get('users/self/feed');
	// }


	public function media($user_id) 
	{
		$data = $this->get('users/'.$user_id.'/media/recent');

		$items = array();
		$media = $data->data;



		foreach($media as $obj) 
		{
			//var_dump($obj);
			if ( $obj->type == "image") 
			{
				$items[] = new Photo($obj);
			}
			else
			{
				//var_dump($obj->videos);
				$items[] = new Video($obj);
			}
		}

		return $items;
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