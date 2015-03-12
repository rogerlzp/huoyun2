<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::group([ 'namespace' => 'Controllers' ], function () {
	
	Route::get('/', [ 'as' => 'home', 'uses' => 'AuthController@home' ]);
	
	
	# Authentication and registration routes
	Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
	Route::post('login', 'AuthController@postLogin');
	
	Route::get('adminlogin', [ 'as' => 'auth.adminlogin', 'uses' => 'AuthController@getLogin' ]);
	Route::post('adminlogin', 'AuthController@postAdminLogin');
	
	Route::get('login/github', [ 'as' => 'auth.login.github', 'uses' => 'AuthController@getLoginWithGithub' ]);
	Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']);
	Route::post('register', 'AuthController@postRegister');
	
	Route::post('register/fmobile', 'AuthController@postRegisterFromMobile');
	Route::post('verify/fmobile', 'AuthController@postVerifyFromMobile');
	Route::post('login/fmobile', 'AuthController@postLoginFromMobile');
	
	// driver register
	Route::post('registerDriver/fmobile', 'AuthController@postRegisterDriverFromMobile');
	
	Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'AuthController@getLogout' ]);
	
	# Password reminder routes
	Route::controller('password', 'RemindersController', [
	'getRemind' => 'auth.remind',
	'getReset'  => 'auth.reset'
			]);
	
	// truck update
	Route::post('updateTruck/fmobile', 'TruckController@postUpdateTruckDriverFromMobile');
	// get truck 
	Route::post('getTruck/fmobile', 'TruckController@postGetTruckInfoFromMobile');
	// update driver license image 
	Route::post('updateDriverLicense/fmobile', 'TruckController@postUpdateDriverLicenseImageFromMobile');
	
	# user
	Route::get('user', [ 'as' => 'user.index', 'uses' => 'UserController@getIndex' ]);
	
	
	Route::get('testsms/yimei1', 'TestYimeiController@showWelcome');
	
	Route::get('testsms/yimei2', 'TestYimeiController@showWelcome2');
	Route::get('test/attach1', 'TestYimeiController@testAttach');
	
	# create horder
	Route::post('createHorder/fmobile', 'HorderController@postCreateHorderFromMobile');

	
});