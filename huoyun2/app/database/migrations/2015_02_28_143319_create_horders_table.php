<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horder_status', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('status');
			$table->string('description');
	    });
					
		Schema::create('horders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('shipper_username');
			$table->string('shipper_phone');
			$table->dateTime('shipper_date');
			$table->string('shipper_address_code');			
			
			$table->string('consignee_username');
			$table->string('consignee_phone');
			$table->string('consignee_address_code');
			
			$table->dateTime('delivery_time');
			
			$table->string('truck_type');
			$table->string('truck_length');
			
			$table->string('cargo_type');
			$table->string('cargo_volume');
			$table->string('cargo_weight');
			
			$table->string('horder_desc');
			
			$table->integer('user_id')->unsigned();
			$table->integer('status')->default(0);
			$table->integer('driver_id')->unsigned()->default(0);
			
			$table->foreign('user_id')->references('id')->on('users')
			->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('driver_id')->references('id')->on('users')
			->onUpdate('cascade')->onDelete('cascade');
			
			$table->timestamps();
		});
		
		Schema::create('horder_sent_drivers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('driver_id')->unsigned();
			$table->integer('horder_id')->unsigned();
			$table->timestamps();
			$table->foreign('driver_id')->references('id')->on('users')
			->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('horder_id')->references('id')->on('horders')
			->onUpdate('cascade')->onDelete('cascade');
			$table->unique(array('horder_id', 'driver_id'));
		});	
		
		Schema::create('horder_replied_drivers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('driver_id')->unsigned();
			$table->integer('horder_id')->unsigned();
			$table->timestamps();
			$table->foreign('driver_id')->references('id')->on('users')
			->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('horder_id')->references('id')->on('horders')
			->onUpdate('cascade')->onDelete('cascade');
			$table->unique(array('horder_id', 'driver_id'));
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
