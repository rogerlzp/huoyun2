<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function($table)
		{
			$table->engine = 'InnoDB';
		
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('name')->nullable()->default(NULL);
			$table->string('profile_image_url')->nullable()->default(NULL);
			$table->string('driver_license_image_url')->nullable()->default(NULL);
			$table->integer('company_id')->unsigned();			
			$table->string('identity_card')->nullable()->default(NULL);
			$table->string('identity_front_image_url')->nullable()->default(NULL);
			$table->string('identity_back_image_url')->nullable()->default(NULL);
			$table->integer('audit_status')->default(0);
			$table->timestamps();
		
			$table->foreign('user_id')
			->references('id')->on('users')
			->onUpdate('cascade')
			->onDelete('cascade');
			
			$table->foreign('company_id')
			->references('id')->on('companies')
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
		Schema::table('profiles', function($table)
		{
			$table->dropForeign('profiles_user_id_foreign');
		});
		
		Schema::drop('profiles');
	}

}
