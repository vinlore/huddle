<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagesConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manages_conference', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('conference_id')->index('conference_id');
			$table->primary(['user_id','conference_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manages_conference');
	}

}
