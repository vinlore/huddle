<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHasAccommodationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('has_accommodation', function(Blueprint $table)
		{
			$table->foreign('conference_id', 'has_accommodation_ibfk_1')->references('conference_id')->on('conference')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('accommodation_id', 'has_accommodation_ibfk_2')->references('accommodation_id')->on('accommodation')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('has_accommodation', function(Blueprint $table)
		{
			$table->dropForeign('has_accommodation_ibfk_1');
			$table->dropForeign('has_accommodation_ibfk_2');
		});
	}

}
