<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagesEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manages_event', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('event_id')->index('event_id');
			$table->primary(['user_id','event_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manages_event');
	}

}
