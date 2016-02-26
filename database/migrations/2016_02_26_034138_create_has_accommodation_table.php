<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHasAccommodationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('has_accommodation', function(Blueprint $table)
		{
			$table->integer('conference_id');
			$table->integer('accommodation_id')->index('accommodation_id');
			$table->primary(['conference_id','accommodation_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('has_accommodation');
	}

}
