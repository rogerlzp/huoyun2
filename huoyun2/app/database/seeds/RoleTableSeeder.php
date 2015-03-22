<?php
class RoleTableSeeder extends Seeder {
	public function run() {
		$roles = [ 
				[ 
						'id' => '1',
						'name' => 'driver' 
				],
				[ 
						'id' => '2',
						'name' => 'huozhu' 
				] 
		]
		;
		
		DB::table ( 'roles' )->insert ( $roles );
	}
}
