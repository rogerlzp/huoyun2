<?php


namespace Huoyun\Events;

use Illuminate\Session\Store;
use Huoyun\Repositories\HorderRepositoryInterface;
use Huoyun\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class NotifyChezhuHandler {
	protected $horders;
	protected $users;
	public function __construct(HorderRepositoryInterface $horders, UserRepositoryInterface $users) {
		$this->horders = $horders;
		$this->users = $users;
	}
	
	/**
	 * Handle the view trick event.
	 *
	 * @param \Tricks\Trick $trick        	
	 * @return void
	 */
	public function handle($horder, $driver_id) {
		$user = $this->users->findByUserId($driver_id);
		Queue::push('Huoyun\Services\Queue\NotifyChezhuQueue', array('device_token'=>$user->device_token));
	}
}