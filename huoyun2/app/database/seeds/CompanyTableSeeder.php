<?php
class CompanyTableSeeder extends Seeder {
	public function run() {
		$companies = [ 
				[ 
						'id' => '1',
						'name' => 'default' 
				],
				[ 
						'id' => '0',
						'name' => 'default2' 
				] 
		]
		;
		
		DB::table ( 'companies' )->insert ( $companies );
	}
}
