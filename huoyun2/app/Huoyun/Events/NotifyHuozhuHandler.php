<?php


namespace Huoyun\Events;

use Illuminate\Session\Store;
use Huoyun\Repositories\HorderRepositoryInterface;
use Huoyun\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class NotifyHuozhuHandler {
	protected $horders;
	protected $users;
	public function __construct(HorderRepositoryInterface $horders) {
		$this->horders = $horders;
	}
	
	/**
	 * Handle the view trick event.
	 *
	 * @param \Tricks\Trick $trick        	
	 * @return void
	 */
	public function handle($horder, $user) {
		Log::info ( $horder->user);
		Log::info ( $horder->user->device_token );
		Queue::push('Huoyun\Services\Queue\NotifyHuozhuQueue', array('device_token'=>$horder->user->device_token));
	}
}