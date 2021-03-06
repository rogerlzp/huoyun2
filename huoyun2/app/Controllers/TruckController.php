<?php

namespace Controllers;

use ImageUpload;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Huoyun\Repositories\UserRepositoryInterface;
use Huoyun\Repositories\TruckRepositoryInterface;
use Huoyun\Repositories\TruckPlanRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TruckController extends BaseController {
	
	/**
	 * Truck repository.
	 *
	 * @var \Huoyun\Repositories\TruckRepositoryInterface
	 */
	protected $trucks;
	
	/**
	 * Truck plan repository.
	 *
	 * @var \Huoyun\Repositories\TruckPlan RepositoryInterface
	 */
	protected $truckplans;
	
	/**
	 * User repository.
	 *
	 * @var \Huoyun\Repositories\UserRepositoryInterface
	 */
	protected $users;
	
	/**
	 * The currently authenticated user.
	 *
	 * @var \User
	 */
	protected $user;
	
	/**
	 * Create a new UserController instance.
	 *
	 * @param \Huoyun\Repositories\UserRepositoryInterface $users        	
	 */
	public function __construct(UserRepositoryInterface $users, TruckRepositoryInterface $trucks, TruckPlanRepositoryInterface $truckplans) {
		Log::info ( ' __construct in UserController' );
		parent::__construct ();
		$this->user = Auth::user ();
		$this->users = $users;
		$this->trucks = $trucks;
		$this->truckplans = $truckplans;
	}
	
	/**
	 * Show the user's tricks page.
	 *
	 * @return \Response
	 */
	public function getIndex() {
		// $tricks = $this->tricks->findAllForUser($this->user, 12);
		$this->view ( 'user.profile' );
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postUpdateTruckDriverFromMobile() {
		Log::info ( "postUpdateTruckDriverFromMobile" );
		
		$data = [ ];
		
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['truck_weight'] = Input::get ( 'truck_weight' );
		$data ['truck_length'] = Input::get ( 'truck_length' );
		$data ['truck_type'] = Input::get ( 'truck_type' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		$data ['truck_license'] = Input::get ( 'truck_license' );
		$data ['truck_status'] = Input::get ( 'truck_status' );
		$data ['tmobile_num'] = Input::get ( 'tmobile_num' );
		
		if ($truck = $this->trucks->createOrUpdateTruckFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'truck_id' => $truck->id 
			) );
		}
	}
	
	/**
	 * 更新truck mobile （刚开始的时候，可能不需要）
	 */
	public function postUpdateTruckMobileFromMobile() {
		Log::info ( "postUpdateTruckDriverFromMobile" );
		
		$data = [ ];
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		$data ['tmobile_num'] = Input::get ( 'tmobile_num' );
		
		if ($truck = $this->trucks->createOrUpdateTruckFromMobile2 ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'truck_id' => $truck->id 
			) );
		}
	}
	public function postUpdateTruckLicenseImageFromMobile() {
		Log::info ( "postUpdateDriverLicenseImageFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . $data ['truck_id'] . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['tl_image_url'] = $path;
		
		if ($truck = $this->trucks->createOrUpdateTruckLicenseImageFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'truck_id' => $truck->id,
					'image_url' => $path 
			) );
		}
	}
	public function postUpdateTruckPhotoFromMobile() {
		Log::info ( "postUpdateDriverLicenseImageFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . $data ['truck_id'] . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['tphoto_image_url'] = $path;
		
		if ($truck = $this->trucks->createOrUpdateTruckPhotoImageFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'truck_id' => $truck->id,
					'image_url' => $path 
			) );
		}
	}
	public function postGetTruckInfoFromMobile() {
		Log::info ( "postGetTruckInfoFromMobile" );
		$userId = Input::get ( 'user_id' );
		Log::info ( "userid: " . $userId );
		$truck = $this->trucks->findByUserId ( $userId );
		return json_encode ( array (
				'result_code' => '0',
				'truck' => $truck 
		) );
	}
	
	/**
	 * 根据条件，返回符合条件的Trucks
	 * TODO: 加入其他匹配条件
	 * 目前返回所有的trucks
	 *
	 * @return string
	 */
	public function getTrucksFromMobile() {
		Log::info ( "getTrucksFromMobile" );
		// $userId = Input::get('user_id');
		// Log::info("userid: ".$userId);
		$offset = Input::get ( 'offset' );
		$pagecount = Input::get ( 'pagecount' );
		$sa_code = Input::get ( 'sa_code' );
		$ca_code = Input::get ( 'ca_code' );
		
		$status = 0;
		Log::info ( 'sa_code' . $sa_code );
		Log::info ( 'ca_code' . $ca_code );
		
		if ($sa_code == 1 && $ca_code == 1) {
			$trucks = $this->trucks->findAll ( $offset, $pagecount );
		} else { // TODO: add other conditions
			$trucks = $this->trucks->findByAddress ($sa_code, $ca_code , $offset, $pagecount);
		}

		$return_trucks = array();
		foreach ( $trucks as $truck ) {
			Log::info($truck);
			$return_truck = array(
					Config::get ( 'constants.TRUCK_LICENSE_IAMGE_URL' ) => $truck->tl_image_url,
					Config::get ( 'constants.TRUCK_PHOTO_IAMGE_URL' ) => $truck->tphoto_image_url,
					Config::get ( 'constants.TRUCK_AUDIT_STATUS' ) => $truck->truck_audit_status,
					Config::get ( 'constants.TRUCK_MOBILE' ) => $truck->truck_mobile,
					Config::get ( 'constants.TRUCK_PLATE' ) => $truck->truck_plate,
					Config::get ( 'constants.TRUCK_TYPE' ) => $truck->truck_type,
					Config::get ( 'constants.TRUCK_LENGTH' ) => $truck->truck_length,
					Config::get ( 'constants.TRUCK_WEIGHT' ) => $truck->truck_weight,
					Config::get ( 'constants.TRUCK_ID' ) => $truck->id,
					Config::get ( 'constants.DRIVER_ID' ) => $truck->user_id,
					Config::get ( 'constants.DRIVER_USERNAME' ) => $truck->user->username, 
					Config::get ( 'constants.NAME' ) => $truck->user->profile->name,
					Config::get ( 'constants.MOBILE' ) => $truck->user->profile->mobile,
					Config::get ( 'constants.PROFILE_IMAGE_URL' ) => $truck->user->profile->profile_image_url,
					Config::get ( 'constants.IDENTITY_FRONT_IMAGE_URL' ) => $truck->user->profile->identity_front_image_url,
					Config::get ( 'constants.IDENTITY_BACK_IMAGE_URL' ) => $truck->user->profile->identity_back_image_url,
					Config::get ( 'constants.USER_AUDIT_STATUS' ) => $truck->user->profile->audit_status,
					Config::get ( 'constants.DRIVER_LICENSE_IAMGE_URL' ) => $truck->user->profile->driver_license_image_url
			 );
			array_push($return_trucks, $return_truck);

		}
		
		
		return json_encode ( array (
				'result_code' => '0',
				'trucks' => $return_trucks 
		) );
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postTruckPlanFromMobile() {
		Log::info ( "createOrUpdateTruckPlanFromMobile" );
		
		$data = [ ];
		
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		
		$data ['truck_shipper_address_code'] = Input::get ( 'truck_shipper_address_code' );
		$data ['truck_consignee_address_code'] = Input::get ( 'truck_consignee_address_code' );
		$data ['truck_shipper_date'] = Input::get ( 'truck_shipper_date' );
		$data ['truck_plan_desc'] = Input::get ( 'truck_plan_desc' );
		
		if ($truckplan = $this->truckplans->createOrUpdateTruckPlanFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'truckplan_id' => $truckplan->id 
			) );
		}
	}
	
	// audit the truck Ï¬
	public function verifyTruckFromMobile() {
		Log::info ( "verifyTruckFromMobile" );
		
		$data = [ ];
		
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['truck_id'] = Input::get ( 'truck_id' );
		
		$data ['truck_type'] = Input::get ( 'truck_type' );
		$data ['truck_length'] = Input::get ( 'truck_length' );
		$data ['truck_weight'] = Input::get ( 'truck_weight' );
		$data ['truck_plate'] = Input::get ( 'truck_plate' );
		$data ['name'] = Input::get ( 'name' ); // update in profile
		$data ['truck_mobile'] = Input::get ( 'truck_mobile' ); // update in truck
		                                                        
		// set truck audit status as 0
		$resultCode1 = $this->trucks->sendTruckToAuditFromMobile ( $data );
		
		$resultCode2 = $this->users->sendUserToAuditFromMobile ( $data );
		return json_encode ( array (
				'result_code' => '0' 
		) );
		// set user audit status as 1
	}
}

