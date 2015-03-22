<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Profile;
use Illuminate\Support\Facades\Log;
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
        return $this->model->whereId($uid)->first();
    }

    /**
     * Find a profile by it's ID.
     *
     * @param  string  $uid
     * @return \Huoyun\Models\Profile
     */
    public function findByUserId($userId)
    {
    	return $this->model->where('user_id', '=', $userId )->first();
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
    
    public function createOrUpdateUserPortraitFromMobile(array $data) {
    	// 首先查找profile
    	$profile = $this->findByUserId($data['user_id']);
    	if (!$profile) {
    		$profile = $this->getNew ();
    		$profile->created_at = new \DateTime ();
    		Log::info("add new profile");
    	} 
    	$profile->user_id = $data ['user_id'];
    	$profile->company_id = 1;// TODO 
    	$profile->profile_image_url = e ( $data ['profile_image_url'] );
  
    	$profile->updated_at = new \DateTime ();
    	
    	$profile->save ();
    	return $profile;
    }
    
    
    public function createOrUpdateUserIdentityImageFromMobile(array $data) {
    	// 首先查找profile
    	$profile = $this->findByUserId($data['user_id']);
    	if (!$profile) {
    		$profile = $this->getNew ();
    		$profile->created_at = new \DateTime ();
    		Log::info("add new profile");
    	}
    	$profile->user_id = $data ['user_id'];
    	$profile->company_id = 1;// TODO
    	$profile->identity_card_image_url = e ( $data ['identity_card_image_url'] );
    
    	$profile->updated_at = new \DateTime ();
    	 
    	$profile->save ();
    	return $profile;
    }
    
    public function createOrUpdateUserNameFromMobile(array $data) {
    	// 首先查找profile
    	$profile = $this->findByUserId($data['user_id']);
    	if (!$profile) {
    		$profile = $this->getNew ();
    		$profile->created_at = new \DateTime ();
    		Log::info("add new profile");
    	}
    	$profile->user_id = $data ['user_id'];
    	$profile->company_id = 1;// TODO
    	$profile->name = e ( $data ['name'] );
    
    	$profile->updated_at = new \DateTime ();
    	 
    	$profile->save ();
    	return $profile;
    }
    
   
    
    public function createOrUpdateUserDriverImageFromMobile(array $data) {
    	// 首先查找profile
    	$profile = $this->findByUserId($data['user_id']);
    	if (!$profile) {
    		$profile = $this->getNew ();
    		$profile->created_at = new \DateTime ();
    		Log::info("add new profile");
    	}
    	$profile->user_id = $data ['user_id'];
    	$profile->company_id = 1;// TODO
    	$profile->driver_license_image_url = e ( $data ['driver_license_image_url'] );
    
    	$profile->updated_at = new \DateTime ();
    
    	$profile->save ();
    	return $profile;
    }
}

