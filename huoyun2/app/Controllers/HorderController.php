<?php namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Huoyun\Repositories\HorderRepositoryInterface;

use Hardywen\Yimei\Facades\YimeiFacade;
use Huoyun\Repositories\Eloquent\UserRepository;
use Huoyun\Repositories\UserRepositoryInterface;

class HorderController extends BaseController
{
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
     * @param  \Tricks\Repositories\UserRepositoryInterface $users
     * @return void
     */
    public function __construct(HorderRepositoryInterface $horders, UserRepositoryInterface $users)
    {
        parent::__construct();
        $this->horders = $horders;
        $this->users = $users;
      
    }
   

    


    /**
     * Show registration form.
     *
     * @return \Response
     */
    public function getRegister()
    {
        $this->view('home.register');
    }

    /**
     * Post registration form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateHorderFromMobile()
    {
    	Log::info("postCreateHorderFromMobile");
    	
    	$data=[];
    	
    
    	
    	$data['user_id'] = Input::get('user_id');
    	$data['shipper_username'] = Input::get('shipper_username');
    	$data['shipper_date'] =  Input::get('shipper_date');
    	$data['shipper_address_code'] =  Input::get('sa_code');
    	
    	$data['consignee_address_code'] =  Input::get('ca_code');
    	
    	$data['truck_type'] =  Input::get('truck_type');
    	$data['truck_length'] =  Input::get('truck_length');
    	
    	$data['cargo_type']  =  Input::get('cargo_type');
    	$data['cargo_volume'] =  Input::get('cargo_volume');
    	$data['cargo_weight'] =  Input::get('cargo_weight');
    	$data['horder_desc']  =  Input::get('horder_desc');
    	
    

    	if ($horder = $this->horders->createFromMobile($data)) {
    		return json_encode(array('result_code'=>'0', 'horder_id'=>$horder->id ));
    	}
    	
    }
    
    /**
     * Get My Horder.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getMyHorderFromMobile()
    {
    	Log::info("getMyHorderFromMobile");  	 
    	$userId= Input::get('user_id');
    	$status = Input::get('horder_status');
    	$offset = Input::get('offset');
    	$pagecount = Input::get('pagecount');
    	Log::info("userId=".$userId);
    	Log::info("status=".$status);

    	
    	$horders = $this->horders->findByStatus($userId, $status, $offset, $pagecount);
    	Log::info('horders='.$horders);
    	return json_encode(array('result_code'=>'0', 'horders'=>$horders));
    
    } 
    

    public function getNewHordersFromMobile() {
    	Log::info("getMyHorderFromMobile");
    	$offset = Input::get('offset');
    	$pagecount = Input::get('pagecount');
    	$status = 0;
    	 
    	$horders = $this->horders->findNewHorderByStatus($status, $offset, $pagecount);
    	Log::info('horders='.$horders);
    	return json_encode(array('result_code'=>'0', 'horders'=>$horders));
    		
    }
    

}
