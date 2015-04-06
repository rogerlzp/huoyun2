<?php namespace Huoyun\Presenters;

use Huoyun\Models\Horder;
use McCool\LaravelAutoPresenter\BasePresenter;

class HorderPresenter extends BasePresenter
{
	/**
	 * Create a new UserPresenter instance.
	 *
	 * @param  \App\Huoyun\Models\User  $user
	 * @return void
	 */
	public function __construct(Horder $hoser)
	{
		$this->resource = $horder;
	}
	
	
	
	/**
	 * Get the full name of this user.
	 *
	 * @return string
	 */
	/*
	public function fullName()
	{
		$profile = $this->resource->profile;
	
		if (! is_null($profile) && ! empty($profile->name)) {
			return $profile->name;
		}
	
		return $this->resource->username;
	}
	*/

}