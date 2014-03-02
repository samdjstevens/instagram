<?php namespace Spanky\Instagram\Entities;

/**
 * Object representing an image or video
 * file associated with an Instagram upload.
 * 
 * e.g a thumbnail jpg of a photo upload, or the 
 * standard resolution video file of a video 
 * upload.
 */

class MediaFile {

	/**
	 * The url of the file.
	 * 
	 * @var string
	 */

	private $url;


	/**
	 * The width of the file.
	 * 
	 * @var int
	 */

	private $width;


	/**
	 * The height of the file.
	 * 
	 * @var int
	 */

	private $height;


	/**
	 * Constructor.
	 * 
	 * @param string $url
	 * @param int $width
	 * @param int $height]
	 */

	public function __construct($url, $width, $height) 
	{
		$this->url = $url;
		$this->width = $width;
		$this->height = $height;
	}


	/**
	 * Retrieve the file url.
	 * 
	 * @return string
	 */

	public function url() 
	{
		return $this->url;
	}


	/**
	 * Retrieve the file width.
	 * 
	 * @return int
	 */

	public function width() 
	{
		return $this->width;
	}


	/**
	 * Retrieve the file height.
	 * 
	 * @return int
	 */

	public function height() 
	{
		return $this->height;
	}
}