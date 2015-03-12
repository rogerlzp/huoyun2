<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('province', function(Blueprint $table)
		{
			$table->engine = "InnoDB";
			$table->increments("id")->unsigned();
			$table->string("province_name");	
		});
		
		Schema::create('city', function(Blueprint $table)
		{
			$table->engine = "InnoDB";
			$table->increments("id")->unsigned();
			$table->string("city_name");
			$table->string("tel_prefix");
			$table->string("zipcode_prefix");
			$table->integer("province_id")->unsigned();
				
			$table->foreign('province_id')->references('id')
			->on('province')->onUpdate('cascade')
			->onDelete('cascade');
		});
		
		
		Schema::create('county', function(Blueprint $table)
		{
			$table->engine = "InnoDB";
			$table->increments("id")->unsigned();
			$table->integer("county_id")->unsigned();
			$table->string("county_name");
			$table->string("tel_prefix");
			$table->string("zipcode_prefix");
			$table->integer("city_id")->unsigned();	
			$table->foreign('city_id')->references('id')
			->on('city')->onUpdate('cascade')
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
