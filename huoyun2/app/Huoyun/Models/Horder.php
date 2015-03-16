<?php namespace Huoyun\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Reminders\RemindableInterface;

class Horder extends Model 
{
	/**
	 * The class to used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Huoyun\Presenters\HorderPresenter';
	

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'horders';

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [  ];

	

	

	
	/**
	 * User following relationship
	 * 
	 */
	
	public function follows() {
	//	return $this->hasMany('Tricks\Follow');
	}
	
	/**
	 * User followers relationship
	 */
	public function followers() {
	//	return $this->hasMany('Tricks\Follow', 'follow_id');
	}
	
	
	/**
	 * Query the tricks that the user has posted.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function addresses()
	{
	//	return $this->hasMany('Tricks\Address');
	}
	

	/**
	 * Query the order that the user has posted.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function torders()
	{
	//	return $this->hasMany('Tricks\Torder');
	}
	

	
	
	/**
	 * 创建该 horder 的用户
	 */
	public function user()
	{
		return $this->belongsTo('Huoyun\Models\User');
	}
	
	
}