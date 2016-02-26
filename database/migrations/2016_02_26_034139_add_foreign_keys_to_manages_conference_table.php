<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToManagesConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('manages_conference', function(Blueprint $table)
		{
			$table->foreign('user_id', 'manages_conference_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('conference_id', 'manages_conference_ibfk_2')->references('conference_id')->on('conference')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('manages_conference', function(Blueprint $table)
		{
			$table->dropForeign('manages_conference_ibfk_1');
			$table->dropForeign('manages_conference_ibfk_2');
		});
	}

}
