<?php namespace Huoyun\Models;

use Illuminate\Database\Eloquent\Model;


class TruckPlan extends Model 
{
	/**
	 * The class to used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Huoyun\Presenters\TruckPlanPresenter';
	

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'truck_plans';

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
	public function truck()
	{
		return $this->belongsTo('Huoyun\Models\Truck');
	}
	
}