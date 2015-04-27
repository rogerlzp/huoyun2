<?php namespace Huoyun\Repositories;

use Huoyun\Models\User;
use League\OAuth2\Client\Provider\User as OAuthUser;

interface UserRepositoryInterface
{
    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\Paginator|\User[]
     */
    public function findAllPaginated($perPage = 200);

    /**
     * Find a user by it's username.
     *
     * @param  string $username
     * @return App\Huoyun\Models\User
     */
    public function findByUsername($username);

    /**
     * Find a user by it's email.
     *
     * @param  string $email
     * @return App\Huoyun\Models\User
     */
    public function findByEmail($email);

    /**
     * Require a user by it's username.
     *
     * @param  string $username
     * @return App\Huoyun\Models\User
     *
     * @throws \Tricks\Exceptions\UserNotFoundException
     */
    public function requireByUsername($username);

    /**
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return App\Huoyun\Models\User
     */
    public function create(array $data);


    public function findByUserId($userId);
    
    /**
     * Update the user's settings.
     *
     * @param  array $data
     * @return App\Huoyun\Models\User
     */
    public function updateSettings(User $user, array $data);
}
