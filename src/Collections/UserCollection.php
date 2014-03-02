<?php namespace Spanky\Instagram\Collections;

use Spanky\Instagram\Entities\User;

class UserCollection extends CollectionAbstract {

	/**
	 * Transform an individual user's data 
	 * into a User object.
	 * 
	 * @param  mixed $data
	 * @return mixed
	 */

	public function transformItem($data) 
	{
		return new User(array(

			'id'				=> (int) $data->id,
			'username'			=> $data->username,
			'profile_picture'	=> $data->profile_picture,
			'full_name'			=> $data->full_name,
			'bio'				=> $data->bio,
			'website'			=> $data->website,

		));
	}
}