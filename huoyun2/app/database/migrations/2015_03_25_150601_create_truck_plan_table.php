<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTruckPlanTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'truck_plans', function ($table) {
			$table->engine = 'InnoDB';
			
			$table->increments ( 'id' )->unsigned ();
			$table->integer ( 'user_id' )->unsigned ();
			$table->integer ( 'truck_id' )->unsigned ();
			
			$table->dateTime ( 'truck_shipper_date' );
			$table->string ( 'truck_shipper_address_code' );
			$table->string ( 'truck_consignee_address_code' );
			$table->string ( 'truck_plan_desc' );
			
			$table->timestamps ();
			
			$table->foreign ( 'user_id' )->references ( 'id' )->on ( 'users' )->onUpdate ( 'cascade' )->onDelete ( 'cascade' );
			$table->foreign ( 'truck_id' )->references ( 'id' )->on ( 'trucks' )->onUpdate ( 'cascade' )->onDelete ( 'cascade' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
}
