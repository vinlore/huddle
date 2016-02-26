<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendsConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attends_conference', function(Blueprint $table)
		{
			$table->foreign('profile_id', 'attends_conference_ibfk_1')->references('profile_id')->on('profile')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('conference_id', 'attends_conference_ibfk_2')->references('conference_id')->on('conference')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attends_conference', function(Blueprint $table)
		{
			$table->dropForeign('attends_conference_ibfk_1');
			$table->dropForeign('attends_conference_ibfk_2');
		});
	}

}
