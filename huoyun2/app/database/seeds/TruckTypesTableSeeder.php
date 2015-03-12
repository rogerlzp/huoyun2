<?php  
class TruckTypesSeeder extends Seeder {

    public function run()
    {
    	
        $truck_types = [
            [
                'id'   => '1',
                'type' => '厢式车',
            ],
            [
                'id'   => '2',
				'type' => '平板车',
            ],
            [
                'id'   => '3',
				'type' => '高低板车',
            ],
        	[
        		'id'   => '4',
        		'type' => '高栏车',
        	],
        	[
        		'id'   => '5',
        		'type' => '中栏车',
        	],
        	[
        		'id'   => '6',
				'type' => '低栏车',
        	],
        	[
        		'id'   => '7',
        		'type' => '罐式车',
        	],
        	[
        		'id'   => '8',
        		'type' => '冷藏车',
        	],
        	[
        		'id'   => '9',
        		'type' => '保温车',
        	],
        	[
        		'id'   => '10',
        		'type' => '危险品车',
        	],
        	[
        		'id'   => '11',
        		'type' => '铁笼车',
        	],
        	[
        		'id'   => '12',
        		'type' => '集装箱',
        	],
        	[
        		'id'   => '13',
        		'type' => '自卸货车',
        	],
        	[
        		'id'   => '14',
        		'type' => '其他车型',
            ],
        		        		
        ];

        DB::table('truck_type')->insert($truck_types);

        $truck_lengths = [
        		[
        				'id'     => '1',
        				'length' => '4.2',
        		],
        		[
        				'id'   => '2',
        				'length' => '5.2',
        		],
        		[
        				'id'   => '3',
        				'length' => '5.8',
        		],
        		[
        				'id'   => '4',
        				'length' => '6.2',
        		],
        		[
        				'id'   => '5',
        				'length' => '6.5',
        		],
        		[
        				'id'   => '6',
        				'length' => '6.8',
        		],
        		[
        				'id'   => '7',
        				'length' => '7.2',
        		],
        		[
        				'id'   => '8',
        				'length' => '8',
        		],
        		[
        				'id'   => '9',
        				'length' => '9.6',
        		],
        		[
        				'id'   => '10',
        				'length' => '12',
        		],
        		[
        				'id'   => '11',
        				'length' => '13',
        		],
        		[
        				'id'   => '12',
        				'length' => '13.5',
        		],
        		[
        				'id'   => '13',
        				'length' => '15',
        		],
        		[
        				'id'   => '14',
        				'length' => '16.5',
        		],
        		[
        				'id'   => '15',
        				'length' => '17.5',
        		],
        		[
        				'id'   => '16',
        				'length' => '18.5',
        		],
        		[
        				'id'   => '17',
        				'length' => '20',
        		],
        		[
        				'id'   => '18',
        				'length' => '22',
        		],
        		[
        				'id'   => '19',
        				'length' => '24',
        		],
        		
        ];
        
        DB::table('truck_length')->insert($truck_lengths);
    

        
        $truck_weights = [
        		[
        				'id'     => '1',
        				'weight' => '1',
        		],
        		[
        				'id'   => '2',
        				'weight' => '2',
        		],
        		[
        				'id'   => '3',
        				'weight' => '3',
        		],
        		[
        				'id'   => '4',
        				'weight' => '4',
        		],
        		[
        				'id'   => '5',
        				'weight' => '5',
        		],
        		[
        				'id'   => '6',
        				'weight' => '6',
        		],
        		[
        				'id'   => '7',
        				'weight' => '7',
        		],
        		[
        				'id'   => '8',
        				'weight' => '8',
        		],
        		[
        				'id'   => '9',
        				'weight' => '9',
        		],
        		[
        				'id'   => '10',
        				'weight' => '10',
        		],
        		[
        				'id'   => '11',
        				'weight' => '11',
        		],
        		[
        				'id'   => '12',
        				'weight' => '12',
        		],
        		[
        				'id'   => '13',
        				'weight' => '13',
        		],
        		[
        				'id'   => '14',
        				'weight' => '14',
        		],
        		[
        				'id'   => '15',
        				'weight' => '15',
        		],
        		[
        				'id'   => '16',
        				'weight' => '16',
        		],
        		[
        				'id'   => '17',
        				'weight' => '17',
        		],
        		[
        				'id'   => '18',
        				'weight' => '18',
        		],
        		[
        				'id'   => '19',
        				'weight' => '19',
        		],
        
        ];
        
        DB::table('truck_weight')->insert($truck_weights);
        
        
    }
}
