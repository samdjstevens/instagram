<?php namespace Spanky\Instagram\Collections;

use Spanky\Instagram\Entities\Photo;
use Spanky\Instagram\Entities\Video;

class MediaCollection extends CollectionAbstract {

	/**
	 * Transform an individual media item's data 
	 * into either a Photo or Video object.
	 * 
	 * @param  mixed $data
	 * @return mixed
	 */

	public function transformItem($data, $api = null ) 
	{
		$mediaData = array(

			'id'			=> $data->id,
			'user'			=> $data->user,
			'caption'		=> isset($data->caption) ? $data->caption->text : null,
			'created_at'	=> $data->created_time,
			'tags'			=> $data->tags,
			'images'		=> $data->images
		);

		if ($data->type == "video" ) $mediaData['videos'] = $data->videos;
		// Add the videos data in if it's there

		return $data->type == "image" ? new Photo($mediaData) : new Video($mediaData);
	}
}