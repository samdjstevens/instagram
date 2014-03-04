<?php namespace Spanky\Instagram\Transformers;

class UserTransformer implements TransformerInterface {

	public function transform($data) 
	{
		return array(

			'id'				=> (int) $data->id,
			'username'			=> $data->username,
			'profile_picture'	=> $data->profile_picture,
			'full_name'			=> $data->full_name,
			'bio'				=> $data->bio,
			'website'			=> $data->website,
			'counts'			=> isset($data->counts) ? (array) $data->counts : null

		);
	}
}