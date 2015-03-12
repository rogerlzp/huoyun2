<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\Role;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;
use Huoyun\Repositories\RoleRepositoryInterface;

use League\OAuth2\Client\Provider\User as OAuthUser;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param  \Tricks\User  $user
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * Find all roles paginated.
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
     * Find a role by it's rolename.
     *
     * @param  string $rolename
     * @return \Huoyun\Models\Role
     */
    public function findByName($name)
    {
        return $this->model->whereName($name)->first();
    }
    
    
    /**
     * Find a role by it's role id.
     *
     * @param  string $roleId
     * @return \Huoyun\Models\Role
     */
    public function findByRoleId($roleId)
    {
    	return $this->model->whereId($roleId)->get();
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
     * Get the user registration form service.
     *
     * @return \Huoyun\Services\Forms\RegistrationForm
     */
    public function getRegistrationForm()
    {
        return app('Huoyun\Services\Forms\RegistrationForm');
    }


    
    
}
