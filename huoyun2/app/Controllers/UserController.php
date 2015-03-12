<?php namespace Controllers;

use ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Huoyun\Repositories\UserRepositoryInterface;

use Illuminate\Support\Facades\Log;

class UserController extends BaseController {
	
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
	public function __construct( UserRepositoryInterface $users)
	{
		Log::info(' __construct in UserController');
		parent::__construct();
	
		$this->beforeFilter('auth', [ 'except' => 'getPublic' ]);
	
		$this->user   = Auth::user();
		$this->users  = $users;
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
	
	
	
}

