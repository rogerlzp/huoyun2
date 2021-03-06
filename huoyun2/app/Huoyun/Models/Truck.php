<?php namespace Huoyun\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Reminders\RemindableInterface;

class Truck extends Model 
{
	/**
	 * The class to used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Huoyun\Presenters\TruckPresenter';
	

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'trucks';

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [  ];

	
	/**
	 *    暂时一个user只有一个truck
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('Huoyun\Models\User');
	}
	
	/**
	 * Query the user's truckPlans
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function truckPlans()
	{
		return $this->hasMany('Huoyun\Models\TruckPlan');
	}
	
}