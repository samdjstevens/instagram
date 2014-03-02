<?php namespace Spanky\Instagram\Entities;

class User {

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
	 * Constructor.
	 * 
	 * Give the user details to the object.
	 * 
	 * @param array $details
	 */

	public function __construct( $details ) 
	{
		$this->id 				= $details['id'];
		$this->username 		= $details['username'];
		$this->full_name 		= $details['full_name'];
		$this->bio 				= $details['bio'];
		$this->website 			= $details['website'];
		$this->profile_picture 	= $details['profile_picture'];
	}
}