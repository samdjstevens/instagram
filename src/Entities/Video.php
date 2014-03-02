<?php namespace Spanky\Instagram\Entities;

class Video extends MediaObject {

	/**
	 * Holds the video information associated
	 * with this video.
	 * 
	 * @var array
	 */

	private $videos;


	public function __construct( $data ) 
	{
		parent::__construct($data);

		$this->videos = array(

			'low'		=> new MediaFile($data['videos']->low_resolution->url, $data['videos']->low_resolution->width, $data['videos']->low_resolution->height),
			'standard'	=> new MediaFile($data['videos']->standard_resolution->url, $data['videos']->standard_resolution->width, $data['videos']->standard_resolution->height),

		);

	}



	/**
	 * Return the low res video MediaFile object.
	 * 
	 * @return Spanky\Instagram\Entities\MediaFile
	 */

	public function lowVideo() 
	{
		return $this->videos['low'];
	}


	/**
	 * Return the standard res video MediaFile object.
	 * 
	 * @return Spanky\Instagram\Entities\MediaFile
	 */

	public function standardVideo() 
	{
		return $this->videos['standard'];
	}
}