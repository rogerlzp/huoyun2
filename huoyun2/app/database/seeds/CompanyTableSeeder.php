<?php  
class CompanyTableSeeder extends Seeder {

    public function run()
    {
    	
        $companies = [
            [
                'id'   => '1',
                'name' => 'default',
            ],
        		        		
        ];

        DB::table('companies')->insert($companies);
    }
}
