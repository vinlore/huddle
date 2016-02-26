<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conference', function(Blueprint $table)
		{
			$table->integer('conference_id', true);
			$table->integer('inventory_id')->index('inventory_id');
			$table->string('conference_name');
			$table->date('start_date');
			$table->date('end_date');
			$table->string('address');
			$table->string('city');
			$table->string('country');
			$table->string('transporation');
			$table->integer('attendee_count')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conference');
	}

}
