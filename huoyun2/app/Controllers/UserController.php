<?php

namespace Controllers;

use ImageUpload;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Huoyun\Repositories\UserRepositoryInterface;
use Huoyun\Repositories\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController {
	
	/**
	 * User repository.
	 *
	 * @var \Huoyun\Repositories\UserRepositoryInterface
	 */
	protected $users;
	
	/**
	 * Profile repository.
	 *
	 * @var \Huoyun\Repositories\ProfileRepositoryInterface
	 */
	protected $profiles;
	
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
	public function __construct(UserRepositoryInterface $users, ProfileRepositoryInterface $profiles) {
		Log::info ( ' __construct in UserController' );
		parent::__construct ();
		
		$this->beforeFilter ( 'auth', [ 
				'except' => array (
						'getPublic',
						'updateUserPortraitFromMobile',
						'postUserProfileFromMobile',
						'updateUserNameFromMobile',
						'updateUserIdentityFrontImageFromMobile',
						'updateUserIdentityBackImageFromMobile',
						'postUpdateDriverLicenseImageFromMobile' 
				) 
		] );
		
		$this->user = Auth::user ();
		$this->users = $users;
		$this->profiles = $profiles;
		Log::info ( ' __construct in UserController ENd' );
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
	public function updateUserPortraitFromMobile() {
		Log::info ( "updateUserPortraitFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . "portrait" . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['profile_image_url'] = $path;
		
		if ($profile = $this->profiles->createOrUpdateUserPortraitFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'image_url' => $path 
			) );
		}
	}
	
	/**
	 * 更新用户身份证照片
	 *
	 * @return string
	 */
	public function updateUserIdentityFrontImageFromMobile() {
		Log::info ( "updateUserIdentityFrontImageFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . "identity" . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['identity_front_image_url'] = $path;
		
		if ($profile = $this->profiles->createOrUpdateUserIdentityFrontImageFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'image_url' => $path 
			) );
		}
	}
	
	/**
	 * 更新用户身份证照片
	 *
	 * @return string
	 */
	public function updateUserIdentityBackImageFromMobile() {
		Log::info ( "updateUserIdentityBackImageFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . "identity" . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['identity_back_image_url'] = $path;
		
		if ($profile = $this->profiles->createOrUpdateUserIdentityBackImageFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'image_url' => $path 
			) );
		}
	}
	public function updateUserNameFromMobile() {
		Log::info ( "updateUserNameFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$data ['name'] = Input::get ( 'name' );
		// decode base64 string
		if ($profile = $this->profiles->createOrUpdateUserNameFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0' 
			) );
		}
	}
	
	// 获取用户信息
	public function postUserProfileFromMobile() {
		Log::info ( "postUserProfileFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		
		if ($user = $this->users->getProfileById ( $data )) {
			// return json_encode(array('result_code'=>'0'));
			return json_encode ( array (
					'result_code' => '0',
					'user' => $user 
			) );
		}
	}
	
	/**
	 * 更新驾驶证照片
	 *
	 * @return string
	 */
	public function postUpdateDriverLicenseImageFromMobile() {
		Log::info ( "postUpdateDriverLicenseImageFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		$bitmapString = Input::get ( 'bitmap' );
		// decode base64 string
		$image = base64_decode ( $bitmapString );
		$png_url = $data ['user_id'] . "_" . "driver_license" . "_" . time () . ".png";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['driver_license_image_url'] = $path;
		
		if ($profile = $this->profiles->createOrUpdateUserDriverImageFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0',
					'image_url' => $path 
			) );
		}
	}
}

