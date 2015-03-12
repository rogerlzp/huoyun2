<?php namespace Huoyun\Repositories\Eloquent;

use Huoyun\Models\User;
use Huoyun\Models\Horder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Huoyun\Services\Forms\SettingsForm;
use Huoyun\Services\Forms\RegistrationForm;
use Huoyun\Exceptions\UserNotFoundException;

use Huoyun\Repositories\HorderRepositoryInterface;

use League\OAuth2\Client\Provider\User as OAuthUser;

class HorderRepository extends AbstractRepository implements HorderRepositoryInterface
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param  \Huoyun\Horder  $horder
     * @return void
     */
    public function __construct(Horder $horder)
    {
        $this->model = $horder;
    }

    /**
     * Find all horders paginated.
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
     * Create a new horder in the database.
     *
     * @param  array  $data
     * @return \Huoyun\Horder
     */
    public function createFromMobile(array $data)
    {
        $horder = $this->getNew();
        

        $horder->user_id    = $data['user_id'];
        $horder->status_id    = 0;
        $horder->shipper_username    = e($data['shipper_username']);
        $horder->shipper_date    = $data['shipper_date'];
        $horder->shipper_address_code    = e($data['shipper_address_code']);
        
        $horder->consignee_address_code    = e($data['consignee_address_code']);
        
        $horder->truck_type    = e($data['truck_type']);
        $horder->truck_length    = e($data['truck_length']);
        
        $horder->cargo_type    = e($data['cargo_type']);
        $horder->cargo_volume    = e($data['cargo_volume']);
        $horder->cargo_weight    = e($data['cargo_weight']);
        $horder->horder_desc    = e($data['horder_desc']);
        $horder->created_at    = new \DateTime();
        $horder->updated_at    = new \DateTime();

        $horder->save();

        return $horder;
    }
    
    
}
