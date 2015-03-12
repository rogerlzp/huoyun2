<?php namespace Huoyun\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Reminders\RemindableInterface;

class Role extends Model 
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'roles';

	

	/**
	 * Query the tricks that the user has posted.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tricks()
	{
		return $this->hasMany('Tricks\Trick');
	}



	/**
	 * Query the votes that are casted by the user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function votes()
	{
	//	return $this->belongsToMany('Tricks\Trick', 'votes');
	}

	
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
	 * Query the product that belong to the attribute.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('Huoyun\Models\User', 'assigned_roles');
	}
	

	
}