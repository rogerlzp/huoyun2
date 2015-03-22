<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;
use Huoyun\Repositories\UserRepositoryInterface;

use League\OAuth2\Client\Provider\User as OAuthUser;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param  \Tricks\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    
    public function getProfileFromMobile(array $data) {
    	$user = $this->model->whereId($data['user_id'])->first();
    	Log::info('user='.$user);
    	Log::info('user info ='.$user->profile()->first());
    	return $user;
    }
    
    public function getProfileFromMobileByMobile($mobile) {
    	$user = $this->model->whereMobile($mobile)->first();
    	Log::info('user='.$user);
    	Log::info('user info ='.$user->profile()->first());
    	return $user;
    }
    
    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return Illuminate\Database\Eloquent\Collection|\Tricks\User[]
     */
    public function findAllPaginated($perPage = 200)
    {
        return $this->model
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Find a user by it's username.
     *
     * @param  string $username
     * @return \Tricks\User
     */
    public function findByUsername($username)
    {
        return $this->model->whereUsername($username)->first();
    }
    
    
    /**
     * Find a user by it's mobile.
     *
     * @param  string $username
     * @return \Tricks\User
     */
    public function findByMobile($mobile)
    {
    	return $this->model->whereMobile($mobile)->first();
    }
    
    
    /**
     * Find a user by it's user id.
     *
     * @param  string $userId
     * @return \Huoyun\Models\User
     */
    public function findByUserId($userId)
    {
    	return $this->model->whereId($userId)->get();
    }
    
    
    
    /**
     * Find a user by it's email.
     *
     * @param  string $email
     * @return \Tricks\User
     */
    public function findByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    /**
     * Require a user by it's username.
     *
     * @param  string $username
     * @return \Tricks\User
     * @throws \Tricks\Exceptions\UserNotFoundException
     */
    public function requireByUsername($username)
    {
        if (! is_null($user = $this->findByUsername($username))) {
            return $user;
        }

        throw new UserNotFoundException('The user "' . $username . '" does not exist!');
    }

    /**
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return \Tricks\User
     */
    public function create(array $data)
    {
        $user = $this->getNew();

        $user->email    = e($data['email']);
        $user->username = e($data['username']);
        $user->password = Hash::make($data['password']);
        $user->photo    = isset($data['image_url']) ? $data['image_url'] : null;

        $user->save();

        return $user;
    }
    
    /**
     * 先检查手机号码是否被注册，再检查是否对应的role存在
     * 如果是，说明已经被注册。 返回10001
     * 否则，成功
     *
     * @param  array  $data
     * @return \Tricks\User
     */
    public function createFromMobile(array $data)
    {
    	$result= [];
    	if (! is_null($user = $this->findByMobile($data['mobile']))) {
    		Log::info(" user is null");
    		if ($user->hasRoleId($data['role_id'])) {
    	//		return 10001; // 该用户名和角色已经被注册了
    			$result['code'] = 10001;
    			$result['user'] = 0;
    			return $result;
    		}
    		else {
    			
    		}
    	}
    	try {
    	$user = $this->getNew();
    	$user->mobile = $data['mobile'];
    	$user->password = Hash::make($data['password']);
    	$user->device_token = $data['device_token'];
    	$user->username = $data['mobile'];
    	$user->save();
    	Log::info("role id:".$data['role_id']);
    	
    	$user->roles()->attach($data['role_id']);
    	$result['code'] = 0;
    	$result['user'] =  $user->id;
    	} catch(Exception $e){
    		Log.d($e);
    	}
    
    	return $result;
    	
    }

    
   public function updateDeviceTokenFromMobile ($uid, $device_token) {
   	
  	 	$user = $this->model->whereId($uid)->first();
   	    $user->device_token = $device_token;
   	    $user->save();
    	
    }
    
    

    /**
     * Returns whether the given username is allowed to be used.
     *
     * @param  string  $username
     * @return bool
     */
    protected function usernameIsAllowed($username)
    {
        return ! in_array(strtolower($username), Config::get('config.forbidden_usernames'));
    }

    /**
     * Update the user's settings.
     *
     * @param  \Tricks\User  $user
     * @param  array $data
     * @return \Tricks\User
     */
    public function updateSettings(User $user, array $data)
    {
        $user->username = $data['username'];
        $user->password = ($data['password'] != '') ? Hash::make($data['password']) : $user->password;

        if ($data['avatar'] != '') {
            File::move(public_path().'/img/avatar/temp/'.$data['avatar'], public_path().'/img/avatar/'.$data['avatar']);

            if ($user->photo) {
                File::delete(public_path().'/img/avatar/'.$user->photo);
            }

            $user->photo = $data['avatar'];
        }

        return $user->save();
    }

    /**
     * Get the user registration form service.
     *
     * @return \Huoyun\Services\Forms\RegistrationForm
     */
    public function getRegistrationForm()
    {
        return app('Huoyun\Services\Forms\RegistrationForm');
    }

    /**
     * Get the user settings form service.
     *
     * @return \Tricks\Services\Forms\SettingsForm
     */
    public function getSettingsForm()
    {
        return app('Huoyun\Services\Forms\SettingsForm');
    }
    

    public function doesFollowUser($id)
    {
    	return Auth::user()->follows->where('follow_id', '=', $id);
    }
    
    
}
