<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaysAtAccommodationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stays_at_accommodation', function(Blueprint $table)
		{
			$table->integer('profile_id');
			$table->integer('room_id')->index('room_id');
			$table->primary(['profile_id','room_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stays_at_accommodation');
	}

}
