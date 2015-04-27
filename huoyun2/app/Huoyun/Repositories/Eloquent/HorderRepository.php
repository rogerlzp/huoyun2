<?php

namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Horder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;
use Huoyun\Repositories\HorderRepositoryInterface;
use League\OAuth2\Client\Provider\User as OAuthUser;

class HorderRepository extends AbstractRepository implements HorderRepositoryInterface {
	/**
	 * Create a new DbUserRepository instance.
	 *
	 * @param \Huoyun\Horder $horder        	
	 * @return void
	 */
	public function __construct(Horder $horder) {
		$this->model = $horder;
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
	
	/**
	 * Find the horder created by the user with the given status
	 * 0: 创造订单，等待车主接货
	 * 1: 车主已经接单
	 * 2: 已经完成
	 */
	public function findByStatus($user_id, $status, $offset, $perPage = 10) {
		Log::info ( "offset=" . $offset );
		Log::info ( "perPage=" . $perPage );
		return $this->model->where ( 'user_id', '=', $user_id )->where ( 'status', '=', $status )->orderBy ( 'created_at', 'desc' )->skip ( $offset )->take ( $perPage )->get ();
		// ->paginate($perPage);
	}
	
	/**
	 * Find the horder created by the user with the given status
	 * 0: 创造订单，等待车主接货
	 * 1: 车主已经接单
	 * 2: 已经完成
	 */
	public function findNewHorderByStatus($status, $offset, $perPage = 10) {
		Log::info ( "offset=" . $offset );
		Log::info ( "perPage=" . $perPage );
		return $this->model->where ( 'status', '=', $status )->orderBy ( 'created_at', 'desc' )->skip ( $offset )->take ( $perPage )->get ();
		// ->paginate($perPage);
	}
	public function findNewHorderByStatusAndLocation($status, $offset, $perPage = 10, $sa_code, $ca_code) {
		return $this->model->where ( 'status', '=', $status )->where ( 'shipper_address_code', 'like', $sa_code . '%' )->where ( 'consignee_address_code', 'like', $ca_code . '%' )->orderBy ( 'created_at', 'desc' )->skip ( $offset )->take ( $perPage )->get ();
	}
	
	/**
	 * Create a new horder in the database.
	 *
	 * @param array $data        	
	 * @return \Huoyun\Horder
	 */
	public function createFromMobile(array $data) {
		$horder = $this->getNew ();
		
		$horder->user_id = $data ['user_id'];
		$horder->status = 0;
		$horder->shipper_username = e ( $data ['shipper_username'] );
		$horder->shipper_date = $data ['shipper_date'];
		$horder->shipper_phone = $data ['shipper_phone'];
		$horder->shipper_address_code = e ( $data ['shipper_address_code'] );
		
		$horder->consignee_address_code = e ( $data ['consignee_address_code'] );
		
		$horder->truck_type = e ( $data ['truck_type'] );
		$horder->truck_length = e ( $data ['truck_length'] );
		
		$horder->cargo_type = e ( $data ['cargo_type'] );
		$horder->cargo_volume = e ( $data ['cargo_volume'] );
		$horder->cargo_weight = e ( $data ['cargo_weight'] );
		$horder->horder_desc = e ( $data ['horder_desc'] );
		$horder->created_at = new \DateTime ();
		
		$horder->driver_id = 1; // default driver
		
		$horder->save ();
		
		return $horder;
	}
	public function getHorderDrivers($id) {
		$Horder1 = Horder::find ( 1 );
		$user = User::find ( 2 );
		
		$Horder1->sentDrivers ()->attach ( $user );
		
		return $this->model->where ( 'id', '=', $id );
	}
	public function driverRequestHorder(array $data) {
		$id = $data ['horder_id'];
		$driver_id = $data ['driver_id'];
		$resultCode = 0;
		
		$horder = $this->model->whereId ( $id )->first ();
		if ($horder) {
			Log::info ( $horder );
			if ($user = User::find ( $driver_id )) {
				foreach ( $horder->repliedDrivers as $repliedDriver ) {
					if ($repliedDriver->id == $driver_id) {
						$horder->repliedDrivers ()->detach ( $user );
						$resultCode = 1;
						return $resultCode;
					}
				}
				$horder->repliedDrivers ()->attach ( $user );
				Event::fire ( 'huozhu.notice', array (
						"horder" => $horder,
						"user" => $user 
				) );
				$resultCode = 0;
				
				/*
				 * if ($horder->hasRepliedDriverId ( $driver_id )) {
				 * Log::inf('driver_id'.$driver_id);
				 * $horder->repliedDrivers ()->detach ( $user );
				 * $resultCode = 1;
				 * } else {
				 * $horder->repliedDrivers ()->attach ( $user );
				 * Event::fire('huozhu.notice', array($horder, $user));
				 * $resultCode = 0;
				 * }
				 */
			}
		}
		return $resultCode;
	}
	public function getHorderById($id) {
		return $this->model->whereId ( $id )->first ();
	}
	public function deleteHorderFromMobile(array $data) {
		//
		$horder = $this->model->whereId ( $data ['horder_id'] )->where ( 'user_id', '=', $data ['user_id'] )->first ();
		if ($horder) {
			$horder->delete ();
			return 0;
		} else {
			return - 1;
		}
	}
	public function getHorderByStatusAndDriver(array $data) {
		$horder_status = $data ['horder_status'];
		$driver_id = $data ['driver_id'];
		$horders = $this->model->whereStatus ( $horder_status )->where ( 'driver_id', '=', $driver_id )->get ();
		return $horders;
	}
	
	// driver 获取工作状态的horder
	public function getWorkingHorderForDriver(array $data) {
		$driver_id = $data ['driver_id'];
		$horders = $this->model->whereIn ( 'status', array (
				1,
				2,
				3 
		) )->where ( 'driver_id', '=', $driver_id )->get ();
		
		return $horders;
	}
	
	// huozhu 获取工作状态的horder
	public function getWorkingHorderForHuozhu(array $data) {
		$user_id = $data ['user_id'];
		$horders = $this->model->whereIn ( 'status', array (
				1,
				2,
				3 
		) )->where ( 'user_id', '=', $user_id )->get ();
		
		foreach ( $horders as $horder ) {
			
			$horder->driver = array (
					"name" => $horder->driver ()->first ()->profile ()->first ()->name,
					"mobile" => $horder->driver ()->first ()->mobile 
			);
		}
		
		Log::info ( $horders );
		return $horders;
	}
	
	
	// huozhu 获取工作状态的horder
	public function getWorkedHorderForHuozhu(array $data) {
		$user_id = $data ['user_id'];
		$horders = $this->model->whereIn ( 'status', array (
				4,
				5
		) )->where ( 'user_id', '=', $user_id )->get ();
	
		foreach ( $horders as $horder ) {
				
			$horder->driver = array (
					"name" => $horder->driver ()->first ()->profile ()->first ()->name,
					"mobile" => $horder->driver ()->first ()->mobile
			);
		}
	
		Log::info ( $horders );
		return $horders;
	}
	
	
	
	public function updateHorderStatus(array $data) {
		$horder_id = $data ['horder_id'];
		Log::info('horder_id'.$horder_id);
		$horder = $this->model->whereId ( $horder_id )->first ();
		if ($horder) {
			Log::info('horder_staus'.$horder->status);
			switch ($horder->status) {
			
				case Config::get ( 'constants.HORDER_STATUS_CONFIRMED' ) :
					$horder->status = Config::get ( 'constants.HORDER_STATUS_SHIPPING' );
					break;
				case Config::get ( 'constants.HORDER_STATUS_SHIPPING' ) :
					$horder->status = Config::get ( 'constants.HORDER_STATUS_CONFIRMED_ARRIVED' );
					break;
				case Config::get ( 'constants.HORDER_STATUS_ARRIVED' ) :
					$horder->status = Config::get ( 'constants.HORDER_STATUS_CONFIRMED_ARRIVED' );
					break;
				default :
					break;
			}
			$horder->save ();
		}
		return $horder->status;
	}
	public function updateDriverId(array $data) {
		Log::info ( 'updateDriverId' );
		$horder_id = $data ['horder_id'];
		$driver_id = $data ['driver_id'];
		$horder = $this->model->whereId ( $horder_id )->first ();
		if ($horder) {
			if ($horder->driver_id == $driver_id) {
				$horder->driver_id = 1;
				$horder->save ();
			} else {
				// 货主选择了该司机
				$horder->driver_id = $driver_id;
				Log::info ( 'status' . Config::get ( 'constants.HORDER_STATUS_CONFIRMED' ) );
				$horder->status = Config::get ( 'constants.HORDER_STATUS_CONFIRMED' );
				$horder->save ();
				Event::fire ( 'chezhu.notice', array (
						"horder" => $horder,
						"driver_id" => $driver_id 
				) );
			}
		}
		return $horder;
	}
}
