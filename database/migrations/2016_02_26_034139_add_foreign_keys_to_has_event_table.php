<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHasEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('has_event', function(Blueprint $table)
		{
			$table->foreign('conference_id', 'has_event_ibfk_1')->references('conference_id')->on('conference')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('event_id', 'has_event_ibfk_2')->references('event_id')->on('event')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('has_event', function(Blueprint $table)
		{
			$table->dropForeign('has_event_ibfk_1');
			$table->dropForeign('has_event_ibfk_2');
		});
	}

}
