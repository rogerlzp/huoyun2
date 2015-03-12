<?php namespace Controllers;

use ImageUpload;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Huoyun\Repositories\UserRepositoryInterface;
use Huoyun\Repositories\TruckRepositoryInterface;

use Illuminate\Support\Facades\Log;

class TruckController extends BaseController {
	
	/**
	 * Truck repository.
	 *
	 * @var \Huoyun\Repositories\TruckRepositoryInterface
	 */
	protected $trucks;

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
	 * @param \Huoyun\Repositories\UserRepositoryInterface  $users
	 */
	public function __construct( UserRepositoryInterface $users, TruckRepositoryInterface $trucks)
	{
		Log::info(' __construct in UserController');
		parent::__construct();
		$this->user   = Auth::user();
		$this->users  = $users;
		$this->trucks  = $trucks;
	}
	
	/**
	 * Show the user's tricks page.
	 *
	 * @return \Response
	 */
	public function getIndex()
	{
	//	$tricks = $this->tricks->findAllForUser($this->user, 12);
	
		$this->view('user.profile');
	}
	
	/**
	 * Post registration form.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postUpdateTruckDriverFromMobile()
	{
		Log::info("postUpdateTruckDriverFromMobile");
		 
		$data=[];
		  
		$data['user_id'] = Input::get('user_id');
		$data['tweight_id'] = Input::get('tweight_id');
		$data['tlength_id'] =  Input::get('tlength_id');
		$data['ttype_id'] =  Input::get('ttype_id');
		$data['truck_id'] =  Input::get('truck_id');
		$data['tlicense'] =  Input::get('tlicense');
		$data['tstatus_id'] =  Input::get('tstatus_id');
		$data['tmobile_num'] =  Input::get('tmobile_num');
	
		if ($truck = $this->trucks->createOrUpdateTruckFromMobile($data)) {
			return json_encode(array('result_code'=>'0', 'truck_id'=>$truck->id ));
		}
		 
	}
	

	
	
	public function postUpdateDriverLicenseImageFromMobile() {
		Log::info("postUpdateDriverLicenseImageFromMobile");
		$data['user_id'] = Input::get('user_id');
		$bitmapString = Input::get('bitmap');
		$data['truck_id'] =  Input::get('truck_id');
		//decode base64 string
		$image = base64_decode($bitmapString);
		$png_url = $data['user_id']."_".$data['truck_id']."_".time().".jpg";
		$path = "/img/users/upload/" . $png_url;
		Image::make($image)->save(public_path().$path);
		$data['tl_image_url'] = $path;
		
		if ($truck = $this->trucks->createOrUpdateTruckLicenseImageFromMobile($data)) {
			return json_encode(array('result_code'=>'0', 'truck_id'=>$truck->id ));
		}
	}
	
	public function postGetTruckInfoFromMobile() {
		Log::info("postGetTruckInfoFromMobile");
		$userId = Input::get('user_id');
		Log::info("userid: ".$userId);
		$truck = $this->trucks->findByUserId($userId);
		return json_encode(array('result_code'=>'0', 'truck'=>$truck));
	}
	
	
	
}

