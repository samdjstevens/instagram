<?php namespace Spanky\Instagram\Entities;

/**
 * Object representing the authorized 
 * Instagram user account.
 */

class AuthorizedUser extends User {

	/**
	 * Get the media liked by the user.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function likedMedia($options = array()) 
	{
		return $this->api->getLikedMedia();
	}
}