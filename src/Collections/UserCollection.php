<?php namespace Spanky\Instagram\Collections;

use Spanky\Instagram\Entities\User;
use Spanky\Instagram\Entities\AuthorizedUser;
use Spanky\Instagram\Transformers\UserTransformer;

class UserCollection extends CollectionAbstract {

	/**
	 * Transform an individual user's data 
	 * into a User object.
	 * 
	 * @param  mixed $data
	 * @return mixed
	 */

	public function transformItem($data, $api = null) 
	{
		$transformer = new UserTransformer();

		return new User($transformer->transform($data), $api);
	}
}