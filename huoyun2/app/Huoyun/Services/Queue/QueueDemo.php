<?php namespace Huoyun\Services\Queue;

use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;

class QueueDemo
{
	public function fire($job, $data) {
		Log::info('This is a test'.time());
		$job->delete();
	}
	
}

