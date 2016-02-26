<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendsEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attends_event', function(Blueprint $table)
		{
			$table->integer('profile_id');
			$table->integer('event_id')->index('event_id');
			$table->boolean('ride_req');
			$table->primary(['profile_id','event_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attends_event');
	}

}
