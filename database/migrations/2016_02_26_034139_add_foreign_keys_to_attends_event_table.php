<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendsEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attends_event', function(Blueprint $table)
		{
			$table->foreign('profile_id', 'attends_event_ibfk_1')->references('profile_id')->on('profile')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('event_id', 'attends_event_ibfk_2')->references('event_id')->on('event')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attends_event', function(Blueprint $table)
		{
			$table->dropForeign('attends_event_ibfk_1');
			$table->dropForeign('attends_event_ibfk_2');
		});
	}

}
