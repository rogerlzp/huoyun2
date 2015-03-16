<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Truck;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;


use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;
use Huoyun\Repositories\TruckRepositoryInterface;
use League\OAuth2\Client\Provider\User as OAuthUser;

class TruckRepository extends AbstractRepository implements TruckRepositoryInterface {
	/**
	 * Create a new DbUserRepository instance.
	 *
	 * @param \Huoyun\Horder $horder        	
	 * @return void
	 */
	public function __construct(Truck $truck) {
		$this->model = $truck;
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
	public function createOrUpdateTruckFromMobile(array $data) {
		// 根据truck Id 判断， 为0则新建truck， 否则更新信息。
		if ($data ['truck_id'] == '0') {
			$truck = $this->getNew ();
			Log::info("add new truck");
		} else if ($data ['truck_id'] != '0') {  // update
			$truck = $this->findById($data ['truck_id']);
			Log::info("update truck");
		}
		$truck->user_id = $data ['user_id'];
		$truck->tweight_id = e ( $data ['tweight_id'] );
		$truck->tlength_id = e($data ['tlength_id']);
		$truck->ttype_id = e ( $data ['ttype_id']);
		$truck->tstatus_id = e ( $data ['tstatus_id']);
		$truck->tmobile_num = e ( $data ['tmobile_num']);
		$truck->tlicense = e ( $data ['tlicense']);
		$truck->created_at = new \DateTime ();
		$truck->updated_at = new \DateTime ();
		
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
