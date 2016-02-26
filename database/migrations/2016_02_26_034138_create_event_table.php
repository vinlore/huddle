<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event', function(Blueprint $table)
		{
			$table->integer('event_id', true);
			$table->string('name');
			$table->date('date');
			$table->time('start_time');
			$table->time('end_time');
			$table->string('facilitator');
			$table->integer('age_limit')->nullable();
			$table->string('gender_limit')->nullable();
			$table->string('transportation');
			$table->integer('attendee_count')->default(0);
			$table->integer('capacity');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event');
	}

}
