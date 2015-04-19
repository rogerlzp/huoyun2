<?php


namespace Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Queue;

class QueueDemoController extends Controller {

	
	public function addQueue(){
	//	$queue = new Queue;
	//	$queue->setAsGlobal();
		/*
		$queue->addConnection([
				'driver' => 'redis',
				'queue' => 'default',
		]);
		*/
		
		//$queue->setAsGlobal();
		
		Queue::push('Huoyun\Services\Queue\QueueDemo', array('message'=>'queue job'));
	}
	
}