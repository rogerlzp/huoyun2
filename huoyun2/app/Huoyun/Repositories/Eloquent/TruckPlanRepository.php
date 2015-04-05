<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Truck;
use Huoyun\Models\TruckPlan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;


use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;
use Huoyun\Repositories\TruckRepositoryInterface;
use Huoyun\Repositories\TruckPlanRepositoryInterface;
use League\OAuth2\Client\Provider\User as OAuthUser;

class TruckPlanRepository extends AbstractRepository implements TruckPlanRepositoryInterface {
	/**
	 * Create a new DbUserRepository instance.
	 *
	 * @param \Huoyun\Horder $horder        	
	 * @return void
	 */
	public function __construct(TruckPlan $truckPlan) {
		$this->model = $truckPlan;
	}
	
	/**
	 * Find all horders paginated.
	 *
	 * @param int $perPage        	
	 * @return Illuminate\Database\Eloquent\Collection|\Tricks\User[]
	 */
	public function findAllPaginated($perPage = 200) {
		return $this->model->orderBy ( 'created_at', 'desc' )->paginate ( $perPage );
	}
	
	
	//TODO: 加入其他条件
	public function findAll($offset, $perPage = 10 ) {
		Log::info("offset=".$offset);
		Log::info("perPage=".$perPage);
		return $this->model->orderBy('created_at', 'desc')
						   ->skip($offset)
						   ->take($perPage)
						   ->get();
	}
	 
	
	public function findById($id){
		return $this->model->whereId($id)->first();
	}

	
	public function findByUserId($userid){
		return $this->model->whereUserId($userid)->first();
	}
	
	/**
	 * Create a new horder in the database.
	 *
	 * @param array $data        	
	 * @return \Huoyun\Horder
	 */
	public function createOrUpdateTruckPlanFromMobile(array $data) {
		// 根据truck Id 判断， 为0则新建truck， 否则更新信息。
		if ($data ['truck_id'] == '0') {
			$truckplan = $this->getNew ();
			$truck->created_at = new \DateTime ();
		} else if ($data ['truck_id'] != '0') {  // updatecreateOrUpdateTruckPlanFromMobile
			$truckplan = $this->findById($data ['truckplan_id']);

			$truck->updated_at = new \DateTime ();
		}
		$truckplan->user_id = $data ['user_id'];
		$truckplan->truck_id = e ( $data ['truck_id'] );
		$truckplan->truck_shipper_address_code    = e($data['truck_shipper_address_code']);
		
		$truckplan->truck_consignee_address_code    = e($data['truck_consignee_address_code']);
		
		$truckplan->truck_shipper_date = e($data ['truck_shipper_date']);
		$truckplan->truck_plan_desc = e ( $data ['truck_plan_desc']);

		
		$truckplan->save ();
		return $truckplan;
	}
	
	/**
	 * Create a new horder in the database.
	 *
	 * @param array $data
	 * @return \Huoyun\Horder
	 */
	public function createOrUpdateTruckFromMobile2(array $data) {
		// 根据truck Id 判断， 为0则新建truck， 否则更新信息。
		if ($data ['truck_id'] == '0') {
			$truck = $this->getNew ();
			Log::info("add new truck");
			$truck->created_at = new \DateTime ();
		} else if ($data ['truck_id'] != '0') {  // update
			$truck = $this->findById($data ['truck_id']);
			Log::info("update truck");
			$truck->updated_at = new \DateTime ();
		}
		$truck->user_id = $data ['user_id'];
	
		$truck->tmobile_num = e ( $data ['tmobile_num']);

	
		$truck->save ();
		return $truck;
	}
	

	
	
	/**
	 * Create a new horder in the database.
	 *
	 * @param array $data
	 * @return \Huoyun\Horder
	 */
	public function createOrUpdateTruckLicenseImageFromMobile(array $data) {
		// 根据truck Id 判断， 为0则新建truck， 否则更新信息。
		if ($data ['truck_id'] == '0') {
			$truck = $this->getNew ();
			Log::info("add new truck");
		} else if ($data ['truck_id'] != '0') {  // update
			$truck = $this->findById($data ['truck_id']);
			Log::info("update truck");
		}
		$truck->user_id = $data ['user_id'];
		$truck->tl_image_url =   $data["tl_image_url"] ;
		$truck->created_at = new \DateTime ();
		$truck->updated_at = new \DateTime ();
		$truck->save ();
		return $truck;
	}
	
	
	/**
	 * 更新truck phpto
	 * @param array $data
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function createOrUpdateTruckPhotoImageFromMobile(array $data) {
		// 根据truck Id 判断， 为0则新建truck， 否则更新信息。
		if ($data ['truck_id'] == '0') {
			$truck = $this->getNew ();
			$truck->created_at = new \DateTime ();
			Log::info("add new truck");
		} else if ($data ['truck_id'] != '0') {  // update
			$truck = $this->findById($data ['truck_id']);
			$truck->updated_at = new \DateTime ();
			Log::info("update truck");
		}
		$truck->user_id = $data ['user_id'];
		$truck->tphoto_image_url =   $data["tphoto_image_url"] ;
		$truck->save ();
		return $truck;
	}
	
	
	/**
	 * Update the specified tag in the database.
	 *
	 * @param mixed $id        	
	 * @param array $data        	
	 * @return \Tricks\Category
	 */
	public function update($id, array $data) {
		$tag = $this->findById ( $id );
		
		$tag->name = $data ['name'];
		$tag->slug = Str::slug ( $tag->name, '-' );
		
		$tag->save ();
		
		return $tag;
	}
}
