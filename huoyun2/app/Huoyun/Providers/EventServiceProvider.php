<?php


namespace Huoyun\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {
	public function boot() {
		$this->app ['events']->listen ( 'huozhu.notice', 'Huoyun\Events\NotifyHuozhuHandler' );
		$this->app ['events']->listen ( 'chezhu.notice', 'Huoyun\Events\NotifyChezhuHandler' );
	}
	
	public function register() {
		
	}
}


