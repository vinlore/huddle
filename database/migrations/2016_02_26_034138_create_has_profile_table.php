<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHasProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('has_profile', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('profile_id')->index('profile_id');
			$table->boolean('is_owner');
			$table->primary(['user_id','profile_id']);
			$table->unique(['user_id','is_owner'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('has_profile');
	}

}
