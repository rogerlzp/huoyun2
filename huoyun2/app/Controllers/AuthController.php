<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Huoyun\Repositories\UserRepositoryInterface;
use Huoyun\Repositories\RoleRepositoryInterface;
use Hardywen\Yimei\Facades\YimeiFacade;
use Huoyun\Models\Role;
use Huoyun\Models\User;
use Huoyun\Models\Profile;

class AuthController extends BaseController {
	/**
	 * User Repository.
	 *
	 * @var \Huoyun\Repositories\UserRepositoryInterface
	 */
	protected $users;
	/**
	 * Role Repository.
	 *
	 * @var \Huoyun\Repositories\RoleRepositoryInterface
	 */
	protected $roles;
	
	/**
	 * Create a new AuthController instance.
	 *
	 * @param \Tricks\Repositories\UserRepositoryInterface $users        	
	 * @return void
	 */
	public function __construct(UserRepositoryInterface $users, RoleRepositoryInterface $roles) {
		parent::__construct ();
		$this->users = $users;
		$this->roles = $roles;
	}
	
	/**
	 * Show login form.
	 * TODO: remove it
	 *
	 * @return \Response
	 */
	public function home() {
		echo "wait";
		// $this->view('home.login');
	}
	
	/**
	 * Show login form.
	 *
	 * @return \Response
	 */
	public function getLogin() {
		$this->view ( 'home.login' );
	}
	
	/**
	 * Post login form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postLogin() {
		$credentials = Input::only ( [ 
				'username',
				'password' 
		] );
		$remember = Input::get ( 'remember', false );
		
		if (str_contains ( $credentials ['username'], '@' )) {
			$credentials ['email'] = $credentials ['username'];
			unset ( $credentials ['username'] );
		}
		
		if (Auth::attempt ( $credentials, $remember )) {
			return $this->redirectIntended ( route ( 'user.index' ) );
		}
		
		return $this->redirectBack ( [ 
				'login_errors' => true 
		] );
	}
	
	/**
	 * Post login form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postLoginFromMobile() {
		$credentials = Input::only ( [ 
				'username',
				'password' 
		] );
		$credentials ['mobile'] = $credentials ['username'];

		$device_token = Input::get ( 'device_token' );
		$role_id = Input::get ( 'role_id' );
		
		Log::info ( "mobile:" . $credentials ['mobile'] );
		Log::info ( "username:" . $credentials ['username'] );
		Log::info ( "password:" . $credentials ['password'] );
		Log::info ( "device_token:" . $device_token);
		
		if (Auth::attempt ( array (
				'mobile' => $credentials ['mobile'],
				'password' => $credentials ['password'] 
		) )) {
			
			if ($user = $this->users->getProfileFromMobileByMobile ( Input::get ( 'username' ) )) {
				Log::info ( 'user:' );
				// 更新device_token
				$this->users->updateDeviceTokenFromMobile ( $user->id, $device_token );
				// return json_encode(array('result_code'=>'0'));
				if ($user->hasRole ( "driver" )) {
					Log::info ( "check user" . 'this is a driver' );
					Log::info ( "check user" . $user );
					$user2 = $this->users->getProfileFromMobileByMobile ( $user->mobile );
					Log::info ( "check user" . $user->profile ()->first () );
					return json_encode ( array (
							'result_code' => '0',
							'user' => $user2,
							'profile' => $user2->profile ()->first () 
					) );
				} else {
					Log::info ( "check user" . 'this is NOT a driver' );
					Log::info ( "check user" . $user );
					Log::info ( "check user" . $user->profile ()->first () );
					$user2 = $this->users->getProfileFromMobileByMobile ( $user->mobile );
					return json_encode ( array (
							'result_code' => '0',
							'user' => $user2,
							'profile' => $user2->profile ()->first () 
					) );
				}
			}
		} else {
			Log::info ( "failed login" );
			return json_encode ( array (
					"result_code" => '10001' 
			) );
		}
	}
	
	/**
	 * Post login form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postAdminLogin() {
		$credentials = Input::only ( [ 
				'username',
				'password' 
		] );
		$remember = Input::get ( 'remember', false );
		
		if (str_contains ( $credentials ['username'], '@' )) {
			$credentials ['email'] = $credentials ['username'];
			unset ( $credentials ['username'] );
		}
		
		if (Auth::attempt ( $credentials, $remember )) {
			return $this->redirectIntended ( route ( 'admin.show' ) );
		}
		
		return $this->redirectBack ( [ 
				'login_errors' => true 
		] );
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
	public function postRegister() {
		$form = $this->users->getRegistrationForm ();
		
		if (! $form->isValid ()) {
			return $this->redirectBack ( [ 
					'errors' => $form->getErrors () 
			] );
		}
		
		if ($user = $this->users->create ( $form->getInputData () )) {
			Auth::login ( $user );
			
			return $this->redirectRoute ( 'user.index', [ ], [ 
					'first_use' => true 
			] );
		}
		
		return $this->redirectRoute ( 'home' );
	}
	
	/**
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postRegisterFromMobile() {
		$data = [ ];
		$data ['mobile'] = Input::get ( 'mobile' );
		$data ['password'] = Input::get ( 'password' );
		$data ['device_token'] = Input::get ( 'device_token' );
		$data ['role_id'] = Input::get ( 'role_id' );
		Log::info('role_id' . $data['role_id']);
		Log::info('mobile' . $data['mobile']);
		
		
		// 返回10001 表示已经被注册
		// 0 表示成功注册
		if ($result = $this->users->createFromMobile ( $data )) {
		
				return json_encode ( array (
						'result_code' =>  $result['code'],
						'user_id' => $result['user']
						
				) );
				
		}
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postRegisterDriverFromMobile() {
		$data = [ ];
		$data ['mobile'] = Input::get ( 'mobile' );
		$data ['password'] = Input::get ( 'password' );
		$data ['device_token'] = Input::get ( 'device_token' );
		$data ['role_id'] = Input::get ( 'role_id' );
		
		if ($user = $this->users->createFromMobile ( $data )) {
			// check is driver role exists
			$driverRole = new Role ();
			$driverRole->name = "driver";
			if (! $driverRole->exists ()) {
				$driverRole->save ();
			}
			
			$user->attachRole ( $driverRole );
			return json_encode ( array (
					'result_code' => '0',
					'user_id' => $user->id 
			) );
		}
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postVerifyFromMobile() {
		$phoneNum = Input::get ( 'mobile' );
		$verify_code = rand ( 100000, 999999 );
		$content = YimeiFacade::getContent ( $verify_code );
		$msg = YimeiFacade::sendSMS ( [ 
				$phoneNum 
		], $content );
		if ($msg == 0) {
			return json_encode ( array (
					'result_code' => '0',
					'verify_code' => $verify_code 
			) );
		} else {
			return json_encode ( array (
					'result_code' => '10001' 
			) );
		}
	}
	
	/**
	 * Logout the user.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogout() {
		Auth::logout ();
		
		return $this->redirectRoute ( 'auth.login', [ ], [ 
				'logout_message' => true 
		] );
	}
}
