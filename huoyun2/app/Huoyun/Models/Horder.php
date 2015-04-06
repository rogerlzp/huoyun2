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

	protected  $fillable = ['id'];

	

	
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
	
	/**
	 * 接受该 horder 的司机
	 */
	public function driver()
	{
		return $this->belongsTo('Huoyun\Models\User', 'driver_id');
	}
	
	
	/**
	 * 该订单推送的司机
	 */
	public  function sentDrivers(){
		return $this->belongsToMany('Huoyun\Models\User', 'horder_sent_drivers', 'horder_id', 'driver_id');
	}
	
	/**
	 * 接受该订单的司机
	 */
	public  function repliedDrivers(){
		return $this->belongsToMany('Huoyun\Models\User', 'horder_replied_drivers', 'horder_id', 'driver_id');
	}
	
	/**
	 * 
	 */
	
	
}