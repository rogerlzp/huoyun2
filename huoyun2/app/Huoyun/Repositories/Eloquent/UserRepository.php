<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return \Tricks\User
     */
    public function createFromMobile(array $data)
    {
    	$user = $this->getNew();
    	$user->mobile = $data['mobile'];
    	$user->password = Hash::make($data['password']);
    	$user->save();
    
    	return $user;
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