<?php namespace Spanky\Instagram\Entities;

/**
 * Object representing the authorized 
 * Instagram user account.
 */

class AuthorizedUser extends User {

	/**
	 * Get the media liked by the authorized user.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function likedMedia($options = array()) 
	{
		return $this->api->getLikedMedia();
	}


	/**
	 * Get the collection of users that have requested
	 * to follow the authorized user.
	 * 
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function requestedBy() 
	{
		return $this->api->getRequestedBy();
	}


	/**
	 * Determine if the authorized user follows
	 * another user.
	 * 
	 * @param  mixed $param
	 * @return bool
	 */

	public function follows($param) 
	{
		$user_id = $param instanceof User ? $param->id : $param;
		// Allow the user to pass in a User object, or an id

		$relationship = $this->api->getRelationship($user_id);

		return $relationship->outgoing_status === 'follows';
	}


	/**
	 * Determine if the authorized user is
	 * followed by another user.
	 * 
	 * @param  mixed $param
	 * @return bool
	 */

	public function isFollowedBy($param) 
	{
		$user_id = $param instanceof User ? $param->id : $param;
		// Allow the user to pass in a User object, or an id

		$relationship = $this->api->getRelationship($user_id);

		return $relationship->incoming_status === 'followed_by';
	}


	/**
	 * Follow a user from the authorized user's
	 * account.
	 * 
	 * @param  mixed $param
	 * @return bool
	 */
	
	public function follow($param) 
	{
		$user_id = $param instanceof User ? $param->id : $param;
		// Allow the user to pass in a User object, or an id
	
		$relationship = $this->api->setRelationship($user_id, 'follow');

		return $relationship->outgoing_status === 'follows';
	}


	/**
	 * Unfollow a user from the authorized user's
	 * account.
	 * 
	 * @param  mixed $param
	 * @return bool
	 */

	public function unfollow($param) 
	{
		$user_id = $param instanceof User ? $param->id : $param;
		// Allow the user to pass in a User object, or an id
	
		$relationship = $this->api->setRelationship($user_id, 'unfollow');

		return $relationship->outgoing_status === 'none';
	}
}