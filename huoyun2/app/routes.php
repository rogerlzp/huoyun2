<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the Closure to execute when that URI is requested.
 * |
 */
Route::group ( [ 
		'namespace' => 'Controllers' 
], function () {
	
	Route::get ( '/', [ 
			'as' => 'home',
			'uses' => 'AuthController@home' 
	] );
	
	Route::get ( 'admin', [
	'as' => 'home',
	'uses' => 'AuthController@home'
			] );
	// Authentication and registration routes
	Route::get ( 'login', [ 
			'as' => 'auth.login',
			'uses' => 'AuthController@getLogin' 
	] );
	Route::post ( 'login', 'AuthController@postLogin' );
	
	Route::get ( 'adminlogin', [ 
			'as' => 'auth.adminlogin',
			'uses' => 'AuthController@getLogin' 
	] );
	Route::post ( 'adminlogin', 'AuthController@postAdminLogin' );
	
	Route::get ( 'login/github', [ 
			'as' => 'auth.login.github',
			'uses' => 'AuthController@getLoginWithGithub' 
	] );
	Route::get ( 'register', [ 
			'as' => 'auth.register',
			'uses' => 'AuthController@getRegister' 
	] );
	Route::post ( 'register', 'AuthController@postRegister' );
	
	Route::post ( 'register/fmobile', 'AuthController@postRegisterFromMobile' );
	Route::post ( 'verify/fmobile', 'AuthController@postVerifyFromMobile' );
	Route::post ( 'login/fmobile', 'AuthController@postLoginFromMobile' );
	
	Route::post ( 'getMyHorder/fmobile', 'HorderController@getMyNewHorderFromMobile' );
	Route::post ( 'getHorder/fmobile', 'AuthController@getHorderFromMobile' );
	
	// driver register
	Route::post ( 'registerDriver/fmobile', 'AuthController@postRegisterDriverFromMobile' );
	
	Route::get ( 'logout', [ 
			'as' => 'auth.logout',
			'uses' => 'AuthController@getLogout' 
	] );
	
	// Password reminder routes
	Route::controller ( 'password', 'RemindersController', [ 
			'getRemind' => 'auth.remind',
			'getReset' => 'auth.reset' 
	] );
	
	// truck update
	Route::post ( 'updateTruck/fmobile', 'TruckController@postUpdateTruckDriverFromMobile' );
	// get truck
	Route::post ( 'getTruck/fmobile', 'TruckController@postGetTruckInfoFromMobile' );
	
	// send for audit
	Route::post ( 'verifyTruck/fmobile', 'TruckController@verifyTruckFromMobile' );
	
	// update user identity
	Route::post ( 'updateVehicleLicenseImage/fmobile', 'TruckController@postUpdateTruckLicenseImageFromMobile' );
	Route::post ( 'updateVehiclePhotoImage/fmobile', 'TruckController@postUpdateTruckPhotoFromMobile' );
	
	// update driver license image
	Route::post ( 'updateDriverLicense/fmobile', 'UserController@postUpdateDriverLicenseImageFromMobile' );
	
	// update truck mobile
	Route::post ( 'updateTruckMobile/fmobile', 'TruckController@postUpdateTruckMobileFromMobile' );
	
	// update truck license image
	Route::post ( 'updateTruckLicenseImage/fmobile', 'TruckController@postUpdateTruckLicenseImageFromMobile' );
	// update truck photo
	Route::post ( 'updateTruckPhoto/fmobile', 'TruckController@postUpdateTruckPhotoFromMobile' );
	// create truck plan
	Route::post ( 'createTruckPlan/fmobile', 'TruckController@postTruckPlanFromMobile' );
	
	// get user profile
	Route::post ( 'getUserProfile/fmobile', 'UserController@postUserProfileFromMobile' );
	// update user portrait
	Route::post ( 'updateUserPortrait/fmobile', 'UserController@updateUserPortraitFromMobile' );
	// update user name
	Route::post ( 'updateUsername/fmobile', 'UserController@updateUserNameFromMobile' );
	// update user identity
	Route::post ( 'updateUserIdentityFrontImage/fmobile', 'UserController@updateUserIdentityFrontImageFromMobile' );
	Route::post ( 'updateUserIdentityBackImage/fmobile', 'UserController@updateUserIdentityBackImageFromMobile' );
	
	// user
	Route::get ( 'user', [ 
			'as' => 'user.index',
			'uses' => 'UserController@getIndex' 
	] );
	
	Route::get ( 'testsms/yimei1', 'TestYimeiController@showWelcome' );
	
	Route::get ( 'testsms/yimei2', 'TestYimeiController@showWelcome2' );
	Route::get ( 'test/attach1', 'TestYimeiController@testAttach' );
	Route::get ( 'test/xinge1', 'TestYimeiController@testXinge' );
	
	// create horder
	Route::post ( 'createHorder/fmobile', 'HorderController@postCreateHorderFromMobile' );
	
	// delete horder
	Route::post ( 'deleteHorder/fmobile', 'HorderController@postDeleteHorderFromMobile' );
	
	Route::post ( 'getTrucks/fmobile', 'TruckController@getTrucksFromMobile' );
	// get new horders
	Route::post ( 'getNewHorder/fmobile', 'HorderController@getNewHordersFromMobile' );
	
	// get driver for horder
	Route::post ( 'getDriverForHorder/fmobile', 'HorderController@getDriverForHorderFromMobile' );
	
	// toggle driver for horder
	Route::post ( 'toggleDriverForHorder/fmobile', 'HorderController@toggleDriverForHorderFromMobile' );
	
	// driver 发送接受horder
	Route::post ( 'requestHorder/fmobile', 'HorderController@requestHorderFromMobile' );
	
	// driver 工作中的 horder
	Route::post ( 'getHorderForDriver/fmobile', 'HorderController@getHorderForDriverFromMobile' );
	
	// driver 工作状态中的horder
	Route::post ( 'getDriverWorkingHorder/fmobile', 'HorderController@getWorkingHorderForDriverFromMobile' );
	
	// driver 完成状态中的horder
	Route::post ( 'getDriverWorkedHorder/fmobile', 'HorderController@getWorkedHorderForDriverFromMobile' );
	
	// driver 设置 horder 为送达
	Route::post ( 'setHorderArrivedByDriver/fmobile', 'HorderController@setHorderArrivedByDriverFromMobile' );
	
	// 货主工作状态中的horder
	Route::post ( 'getMyWorkingHorder/fmobile', 'HorderController@getWorkingHorderForHuozhuFromMobile' );
	
	// 货主完成状态中的horder
	Route::post ( 'getMyWorkedHorder/fmobile', 'HorderController@getWorkedHorderForHuozhuFromMobile' );
	
	// 货主修改工作状态中的horder
	Route::post ( 'updateHorderStatus/fmobile', 'HorderController@updateHorderStatusFromMobile' );
	
	Route::get ( 'horder/test1', 'HorderController@testGetHorderDrivers' );
	
	// queue demo
	
	Route::get ( 'queue/test1', 'QueueDemoController@addQueue' );
	Route::get ( 'pivot/test1', 'HorderController@test1' );
} );

