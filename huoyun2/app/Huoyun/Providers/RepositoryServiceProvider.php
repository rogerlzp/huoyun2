<?php namespace Huoyun\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Huoyun\Repositories\UserRepositoryInterface',
            'Huoyun\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'Huoyun\Repositories\ProfileRepositoryInterface',
            'Huoyun\Repositories\Eloquent\ProfileRepository'
        );

        $this->app->bind(
        		'Huoyun\Repositories\HorderRepositoryInterface',
        		'Huoyun\Repositories\Eloquent\HorderRepository'
        );
        
        $this->app->bind(
        		'Huoyun\Repositories\RoleRepositoryInterface',
        		'Huoyun\Repositories\Eloquent\RoleRepository'
        );

        $this->app->bind(
        		'Huoyun\Repositories\TruckRepositoryInterface',
        		'Huoyun\Repositories\Eloquent\TruckRepository'
        );

        $this->app->bind(
        		'Huoyun\Repositories\TruckPlanRepositoryInterface',
        		'Huoyun\Repositories\Eloquent\TruckPlanRepository'
        );
        $this->app->bind(
        		'Huoyun\Repositories\ProfileRepositoryInterface',
        		'Huoyun\Repositories\Eloquent\ProfileRepository'
        );
        
    }
}
