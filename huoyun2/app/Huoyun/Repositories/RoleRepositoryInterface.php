<?php namespace Huoyun\Repositories;

use Huoyun\Models\Role;
use League\OAuth2\Client\Provider\User as OAuthUser;

interface RoleRepositoryInterface
{
    /**
     * Find all roles paginated.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\Paginator|\Role[]
     */
    public function findAllPaginated($perPage = 200);

    /**
     * Find a role by it's rolename.
     *
     * @param  string rolename
     * @return App\Huoyun\Models\Role
     */
    public function findByName($name);

   
    /**
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return App\Huoyun\Models\User
     */
    public function create(array $data);


}
