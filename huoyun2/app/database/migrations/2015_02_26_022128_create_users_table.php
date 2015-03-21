<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('username')->nullable()->default(NULL);
			$table->string('email')->nullable()->default(NULL);
			$table->string('mobile', 11)->nullable()->default(NULL);
			$table->string('password', 60);
			$table->string('photo')->nullable()->default(NULL);
			$table->boolean('is_admin')->default(0);
			$table->rememberToken();
			$table->timestamps();
			$table->string('device_token', 60);
			$table->string('access_token', 60);
			
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}
	
}
