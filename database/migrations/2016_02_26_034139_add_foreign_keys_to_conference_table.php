<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConferenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conference', function(Blueprint $table)
		{
			$table->foreign('inventory_id', 'conference_ibfk_1')->references('inventory_id')->on('inventory')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conference', function(Blueprint $table)
		{
			$table->dropForeign('conference_ibfk_1');
		});
	}

}
