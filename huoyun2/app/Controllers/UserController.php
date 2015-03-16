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
						'postUserProfileFromMobile' 
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
		$png_url = $data ['user_id'] . "_" . "portrait" . "_" . time () . ".jpg";
		$path = "/img/users/upload/" . $png_url;
		Image::make ( $image )->save ( public_path () . $path );
		$data ['profile_image_url'] = $path;
		
		if ($profile = $this->profiles->createOrUpdateUserPortraitFromMobile ( $data )) {
			return json_encode ( array (
					'result_code' => '0' 
			) );
		}
	}
	
	// 获取用户信息
	public function postUserProfileFromMobile() {
		Log::info ( "postUserProfileFromMobile" );
		$data ['user_id'] = Input::get ( 'user_id' );
		
		if ($user = $this->users->getProfileFromMobile ( $data )) {
			Log::info ( 'user:' );
			// return json_encode(array('result_code'=>'0'));
			return json_encode ( array (
					'result_code' => '0',
					'user' => $user,
					'profile'=>$user->profile()->first() 
			) );
		}
	}
	
}

