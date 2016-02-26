<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStaysAtAccommodationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stays_at_accommodation', function(Blueprint $table)
		{
			$table->foreign('profile_id', 'stays_at_accommodation_ibfk_1')->references('profile_id')->on('profile')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('room_id', 'stays_at_accommodation_ibfk_2')->references('room_id')->on('room')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stays_at_accommodation', function(Blueprint $table)
		{
			$table->dropForeign('stays_at_accommodation_ibfk_1');
			$table->dropForeign('stays_at_accommodation_ibfk_2');
		});
	}

}
