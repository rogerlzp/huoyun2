<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Huoyun\Repositories\HorderRepositoryInterface;
use Hardywen\Yimei\Facades\YimeiFacade;
use Huoyun\Repositories\Eloquent\UserRepository;
use Huoyun\Repositories\UserRepositoryInterface;

class HorderController extends BaseController {
	/**
	 * Horder Repository.
	 *
	 * @var \Huoyun\Repositories\HorderRepositoryInterface
	 */
	protected $horders;
	
	/**
	 * User Repository
	 */
	protected $users;
	
	/**
	 * Create a new AuthController instance.
	 *
	 * @param \Tricks\Repositories\UserRepositoryInterface $users        	
	 * @return void
	 */
	public function __construct(HorderRepositoryInterface $horders, UserRepositoryInterface $users) {
		parent::__construct ();
		$this->horders = $horders;
		$this->users = $users;
	}
	
	/**
	 * Show registration form.
	 *
	 * @return \Response
	 */
	public function getRegister() {
		$this->view ( 'home.register' );
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCreateHorderFromMobile() {
		Log::info ( "postCreateHorderFromMobile" );
		
		$data = [ ];
		
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['shipper_username'] = Input::get ( 'shipper_username' );
		$data ['shipper_date'] = Input::get ( 'shipper_date' );
		$data ['shipper_phone'] = Input::get ( 'shipper_phone' );
		$data ['shipper_address_code'] = Input::get ( 'sa_code' );
		
		$data ['consignee_address_code'] = Input::get ( 'ca_code' );
		
		$data ['truck_type'] = Input::get ( 'truck_type' );
		$data ['truck_length'] = Input::get ( 'truck_length' );
		
		$data ['cargo_type'] = Input::get ( 'cargo_type' );
		$data ['cargo_volume'] = Input::get ( 'cargo_volume' );
		$data ['cargo_weight'] = Input::get ( 'cargo_weight' );
		$data ['horder_desc'] = Input::get ( 'horder_desc' );
		
		if ($horder = $this->horders->createFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'horder_id' => $horder->id 
			) );
		}
	}
	public function postDeleteHorderFromMobile() {
		Log::info ( "postCreateHorderFromMobile" );
		
		$data = [ ];
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$result = $this->horders->deleteHorderFromMobile ( $data );
		
		return json_encode ( array (
				'result_code' => $result 
		) );
	}
	
	/**
	 * Get My Horder.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getMyHorderFromMobile() {
		Log::info ( "getMyHorderFromMobile" );
		$userId = Input::get ( 'user_id' );
		$status = Input::get ( 'horder_status' );
		$offset = Input::get ( 'offset' );
		$pagecount = Input::get ( 'pagecount' );
		Log::info ( "userId=" . $userId );
		Log::info ( "status=" . $status );
		
		$horders = $this->horders->findByStatus ( $userId, $status, $offset, $pagecount );
		// TODO: 优化搜索
		foreach ( $horders as $horder ) {
			$horder->sent_drivers = $horder->sentDrivers ()->select ( 'driver_id' )->get ();
			$horder->replied_drivers = $horder->repliedDrivers ()->select ( 'driver_id' )->get ();
		}
		Log::info ( 'horders=' . $horders );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders 
		) );
	}
	public function getNewHordersFromMobile() {
		Log::info ( "getMyHorderFromMobile" );
		$offset = Input::get ( 'offset' );
		$pagecount = Input::get ( 'pagecount' );
		$driver_id = Input::get ( 'driver_id' );
		
		$sa_code = Input::get ( 'sa_code' );
		$ca_code = Input::get ( 'ca_code' );
		
		$status = 0;
		Log::info ( 'sa_code' . $sa_code );
		Log::info ( 'ca_code' . $ca_code );
		
		if ($sa_code == 1 && $ca_code == 1) {
			$horders = $this->horders->findNewHorderByStatus ( $status, $offset, $pagecount );
		} else { // TODO: add other conditions
			$horders = $this->horders->findNewHorderByStatusAndLocation ( $status, $offset, $pagecount, $sa_code, $ca_code );
		}
		// TODO: 优化搜索
		foreach ( $horders as $horder ) {
			// $horder->sent_drivers = $horder->sentDrivers ()->select ( 'driver_id' )->get ();
			$replied_drivers = $horder->repliedDrivers ()->select ( 'driver_id' )->get ();
			$IS_CONTAINED = 0;
			foreach ( $replied_drivers as $replied_driver ) {
				if ($replied_driver->driver_id == $driver_id) { // 已经包含了
					$IS_CONTAINED = 1;
					break;
				}
			}
			$horder->replied_drivers_count = count ( $replied_drivers );
			$horder->is_driver_replied = $IS_CONTAINED;
		}
		
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders 
		) );
	}
	public function testGetHorderDrivers() {
		$horders = $this->horders->getHorderDrivers ( 1 )->get ();
		
		foreach ( $horders as $horder ) {
			$horder->sentDrivers = $horder->sentDrivers ();
		}
		echo $horders;
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders 
		) );
	}
	// driver 发送接单申请
	public function requestHorderFromMobile() {
		Log::info ( 'requestHorderFromMobile' );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		
		$result = $this->horders->driverRequestHorder ( $data );
		
		return json_encode ( array (
				'result_code' => $result 
		) ); // TODO: 增加错误处理
	}
	public function toggleDriverForHorderFromMobile() {
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$data ['user_id'] = Input::get ( 'user_id' );
		
		$horder = $this->horders->updateDriverId ( $data );
		if ($horder->driver_id == 1) { // 取消了司机
			return json_encode ( array (
					'result_code' => '1' 
			) );
		} else { // 添加了司机
			return json_encode ( array (
					'result_code' => '0' 
			) );
		}
	}
	public function getHorderForDriverFromMobile() {
		Log::info ( "getHorderForDriverFromMobile" );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_status'] = Input::get ( 'horder_status' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
		
		$horders = $this->horders->getHorderByStatusAndDriver ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders 
		) );
	}
	public function getDriverForHorderFromMobile() {
		Log::info ( "getDriverForHorderFromMobile" );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		
		Log::info ( 'driver_id' . $data ['driver_id'] );
		Log::info ( 'horder_id' . $data ['horder_id'] );
		
		$horder = $this->horders->getHorderById ( $data ['horder_id'] );
		$reqUsers = $horder->repliedDrivers ()->get ();
		
		foreach ( $reqUsers as $reqUser ) {
			$reqUser->profile = $reqUser->profile ()->first ();
			$reqUser->truck = $reqUser->truck ();
		}
		Log::info ( $reqUser );
		return json_encode ( array (
				'result_code' => '0',
				'users' => $reqUsers 
		) );
		/*
		 * if ($user = $this->users->findByUserId ( $data ['driver_id'] )) {
		 * Log::info ( 'user:' );
		 * // return json_encode(array('result_code'=>'0'));
		 * return json_encode ( array (
		 * 'result_code' => '0',
		 * 'user' => $user,
		 * 'profile' => $user->profile ()->first (),
		 * 'truck' => $user->truck ()
		 * ) );
		 * } else {
		 * return json_encode ( array (
		 * 'result_code' => '10001'
		 * ) );
		 * }
		 */
	}
	
	// driver 中的 working horder
	public function getWorkingHorderForDriverFromMobile() {
		Log::info ( 'getWorkingHorderForDriverFromMobile' );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
		
		$horders = $this->horders->getWorkingHorderForDriver ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders 
		) );
	}
	// driver 中的 working horder
	public function getWorkedHorderForDriverFromMobile() {
		Log::info ( 'getWorkedHorderForDriverFromMobile' );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
	
		$horders = $this->horders->getWorkedHorderForDriver ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders
		) );
	}
	
	
	
	// huozhu 中的 working horder
	public function getWorkingHorderForHuozhuFromMobile() {
		Log::info ( 'getWorkingHorderForHuozhuFromMobile' );
		$data = [ ];
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
		
		$horders = $this->horders->getWorkingHorderForHuozhu ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders
		) );
	}
	// huozhu 中的 history horder
	public function getWorkedHorderForHuozhuFromMobile() {
		Log::info ( 'getWorkedHorderForHuozhuFromMobile' );
		$data = [ ];
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
		
		$horders = $this->horders->getWorkedHorderForHuozhu ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horders' => $horders
		) );
	}
	
	// huozhu 中的 working horder
	public function updateHorderStatusFromMobile() {
		Log::info ( 'updateHorderStatusFromMobile' );
		$data = [ ];
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$data['offset'] = Input::get ( 'offset' );
		$data['pagecount'] = Input::get ( 'pagecount' );
		
		$statusCode = $this->horders->updateHorderStatus ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horder_status'=>$statusCode
		) );
	}
	
	// setHorderArrivedByDriverFromMobile
	public function setHorderArrivedByDriverFromMobile() {
		Log::info ( 'updateHorderStatusFromMobile' );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		$statusCode = $this->horders->updateHorderStatusByDriver ( $data );
		return json_encode ( array (
				'result_code' => '0',
				'horder_status'=>$statusCode
		) );
	}
	
	
	public function test1() {
		Log::info ( "getDriverForHorderFromMobile" );
		$data = [ ];
		$data ['driver_id'] = Input::get ( 'driver_id' );
		$data ['horder_id'] = Input::get ( 'horder_id' );
		
		$horder = $this->horders->getHorderById ( 14 );
		$reqUsers = $horder->repliedDrivers ()->get ();
		
		foreach ( $reqUsers as $reqUser ) {
			Log::info ( $reqUser->profile ()->getForeignKey () );
			
			$reqUser->profile = $reqUser->profile ()->first ();
			$reqUser->truck = $reqUser->truck ();
		}
		Log::info ( $reqUser );
		return json_encode ( array (
				'result_code' => '0',
				'users' => $reqUsers 
		) );
	}
}
