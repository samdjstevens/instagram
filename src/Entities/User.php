<?php namespace Spanky\Instagram\Entities;

use Spanky\Instagram\Instagram;

/**
 * Object representing an Instagram user
 * account.
 */

class User {

	/**
	 * The Instagram object
	 *
	 * @var Spanky\Instagram\Instagram
	 */
	
	protected $api;


	/**
	 * The ID for this user.
	 * 
	 * @var int
	 */

	public $id;


	/**
	 * The user's username.
	 * 
	 * @var string
	 */

	public $username;


	/**
	 * The user's full name.
	 * 
	 * @var string
	 */

	public $full_name;


	/**
	 * The user's bio.
	 * 
	 * @var string
	 */

	public $bio;


	/**
	 * The user's website.
	 * 
	 * @var string
	 */

	public $website;



	/**
	 * The URL of the user's profile picture.
	 * 
	 * @var string
	 */

	public $profile_picture;


	/**
	 * The media/following/followers
	 * count data.
	 * 
	 * @var array
	 */

	public $counts;


	/**
	 * Constructor.
	 * 
	 * Give the user details to the object.
	 * 
	 * @param array $details
	 */

	public function __construct( $details, $api = null ) 
	{
		$this->id 				= $details['id'];
		$this->username 		= $details['username'];
		$this->full_name 		= $details['full_name'];
		$this->bio 				= $details['bio'];
		$this->website 			= $details['website'];
		$this->profile_picture 	= $details['profile_picture'];
		$this->counts 			= $details['counts'];
		// Set the user details

		$this->api = $api;
		// Save the api object
	}


	/**
	 * Get the number of users that follow
	 * this user.
	 * 
	 * @return int
	 */

	public function followerCount() 
	{
		return $this->counts['followed_by'];
	}


	/**
	 * Get the number of users this user is
	 * following.
	 * 
	 * @return int
	 */

	public function followingCount() 
	{
		return $this->counts['follows'];
	}


	/**
	 * Get the number of media items the user
	 * has uploaded.
	 * 
	 * @return int
	 */

	public function mediaCount() 
	{
		return $this->counts['media'];
	}


	/**
	 * Get the recent media uploaded by the user.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\MediaCollection
	 */

	public function recentMedia($options = array()) 
	{
		return $this->api->getRecentMedia($this->id, $options);
	}


	/**
	 * Get the collection of users that follow this 
	 * user.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function followers($options = array()) 
	{
		return $this->api->getFollowers($this->id, $options);
	}


	/**
	 * Get the collection of users that this user 
	 * follows.
	 * 
	 * @param  array  $options
	 * @return Spanky\Instagram\Collections\UserCollection
	 */

	public function following($options = array()) 
	{
		return $this->api->getFollowing($this->id, $options);
	}
}