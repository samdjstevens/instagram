<?php namespace Spanky\Instagram\Entities;

use DateTime;

class MediaObject {

	/**
	 * The id of the media object.
	 * 
	 * @var string
	 */

	public $id;


	/**
	 * The User object that uploaded the 
	 * media object.
	 * 
	 * @var Spanky\Instagram\Entities\User
	 */

	public $user;


	/**
	 * The caption this media object has.
	 * 
	 * @var null|string
	 */

	public $caption;


	/**
	 * The DateTime object representing when
	 * the media object was created.
	 * 
	 * @var DateTime
	 */

	public $created_at;


	/**
	 * The tags associated with this media object.
	 * 
	 * @var array
	 */

	public $tags;


	/**
	 * Holds the static image information
	 * associated with the media object.
	 * 
	 * @var array
	 */

	private $images;


	/**
	 * Set all the data.
	 * 
	 * @param array $data
	 */

	public function __construct( $data ) 
	{
		$this->id = $data['id'];

		$this->user = new User(array(

			'id'				=> $data['user']->id,
			'username'			=> $data['user']->username,
			'profile_picture'	=> $data['user']->profile_picture,
			'full_name'			=> $data['user']->full_name,
			'bio'				=> $data['user']->bio,
			'website'			=> $data['user']->website,

		));

		$this->caption = $data['caption'];

		$this->created_at = new DateTime();
		$this->created_at->setTimestamp($data['created_at']);
		// set the dateTime object from the timestamp

		$this->tags = $data['tags'];

		$this->images = array(

			'thumbnail'	=> new MediaFile($data['images']->thumbnail->url, $data['images']->thumbnail->width, $data['images']->thumbnail->height),
			'low'		=> new MediaFile($data['images']->low_resolution->url, $data['images']->low_resolution->width, $data['images']->low_resolution->height),
			'standard'	=> new MediaFile($data['images']->standard_resolution->url, $data['images']->standard_resolution->width, $data['images']->standard_resolution->height),

		);
	}


	/**
	 * Return the thumbnail image MediaFile object.
	 * 
	 * @return Spanky\Instagram\Entities\MediaFile
	 */

	public function thumbnailImage() 
	{
		return $this->images['thumbnail'];
	}


	/**
	 * Return the low res image MediaFile object.
	 * 
	 * @return Spanky\Instagram\Entities\MediaFile
	 */

	public function lowImage() 
	{
		return $this->images['low'];
	}


	/**
	 * Return the standard res image MediaFile object.
	 * 
	 * @return Spanky\Instagram\Entities\MediaFile
	 */

	public function standardImage() 
	{
		return $this->images['standard'];
	}
}