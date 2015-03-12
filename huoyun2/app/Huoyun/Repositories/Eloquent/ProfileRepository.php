<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Profile;
use Huoyun\Repositories\ProfileRepositoryInterface;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{
    /**
     * Create a new DbProfileRepository instance.
     *
     * @param  \Tricks\Profile $profile
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    /**
     * Find a profile by it's ID.
     *
     * @param  string  $uid
     * @return \Huoyun\Models\Profile
     */
    public function findById($uid)
    {
        return $this->model->whereId($id)->first();
    }

    
    /**
     * Update the access token on the profile.
     *
     * @param  \Tricks\Profile  $profile
     * @param  string  $token
     * @return \Tricks\Profile
     */
    public function updateToken(Profile $profile, $token)
    {
        $profile->access_token = $token;
        $profile->save();

        return $profile;
    }
}
