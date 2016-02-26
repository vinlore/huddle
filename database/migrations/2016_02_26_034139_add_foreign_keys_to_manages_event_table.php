<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToManagesEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('manages_event', function(Blueprint $table)
		{
			$table->foreign('user_id', 'manages_event_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('event_id', 'manages_event_ibfk_2')->references('event_id')->on('event')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('manages_event', function(Blueprint $table)
		{
			$table->dropForeign('manages_event_ibfk_1');
			$table->dropForeign('manages_event_ibfk_2');
		});
	}

}
