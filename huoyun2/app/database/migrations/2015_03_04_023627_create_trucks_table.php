<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('truck_weight', function($table)
		{
			$table->engine = 'InnoDB';
		
			$table->increments('id')->unsigned();
			$table->integer('weight')->unsigned();
			$table->string('description');
		});
		Schema::create('truck_length', function($table)
		{
			$table->engine = 'InnoDB';
		
			$table->increments('id')->unsigned();
			$table->decimal('length', 10,2 );
			$table->string('description');
		});
		Schema::create('truck_type', function($table)
		{
			$table->engine = 'InnoDB';
		
			$table->increments('id')->unsigned();
			$table->string('type');
			$table->string('description');
		});
		*/
		
		Schema::create('trucks', function($table)
		{
			$table->engine = 'InnoDB';
		
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('truck_status')->nullable()->default(0);
			$table->integer('truck_audit_status')->nullable()->default(0);
			$table->integer('truck_weight')->unsigned();
			$table->integer('truck_length')->unsigned();
			$table->integer('truck_type')->unsigned();			
			$table->string('tmobile_num');
			$table->string('truck_license');
			$table->string('tl_image_url')->nullable()->default(NULL);
			
			$table->string('tphoto_image_url')->nullable()->default(NULL);
			
			$table->timestamps();
		
			$table->foreign('user_id')
			->references('id')->on('users')
			->onUpdate('cascade')
			->onDelete('cascade');
			
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
