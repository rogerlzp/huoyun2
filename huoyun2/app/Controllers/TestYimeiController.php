<?php namespace Controllers;

use Illuminate\Routing\Controller;
use Huoyun\Models\User;
use Huoyun\Models\Role;

use Hardywen\Yimei\Facades\YimeiFacade;

class TestYimeiController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		echo "msg send";
		$content = YimeiFacade::getContent(rand(100000,999999)); 
	//	$content = "【货运公司】2015第一个号码，请查收";
		echo $content;
		$msg = YimeiFacade::sendSMS(['15800911536'], $content);

		echo $msg;
	}
	
	public function showWelcome2()
	{
	 $str	 =  rand(100000,999999);
	 echo $str;
		
	}
	
	public function testAttach()
	{
		$user  = User::find(9);
		$role = new Role();
		$role->name = "testRole";
	//if ($role->fin)
	//	$role->save();
		if ($user->hasRole("testRole")) {
			echo 'has role';
		} else {
			echo 'not has role';
		$user->roles()->attach($role);
		}
	
	}
	
	

}
