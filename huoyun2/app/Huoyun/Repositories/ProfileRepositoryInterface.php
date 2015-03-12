<?php namespace Huoyun\Repositories;

use Huoyun\Models\User;
use Huoyun\Models\Profile;

interface ProfileRepositoryInterface
{
    /**
     * Find a profile by it's ID.
     *
     * @param  string $id
     * @return \Huoyun\Models\Profile
     */
    public function findById($id);

   
    /**
     * Update the access token on the profile.
     *
     * @param  \Tricks\Profile $profile
     * @param  string  $token
     * @return \Tricks\Profile
     */
   //  public function updateToken(Profile $profile, $token);
}
